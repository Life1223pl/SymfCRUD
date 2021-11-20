<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{



    /**
     * @Route("/article/update/{id}", name="update_article")
     * @Method({"GET","POST"})
     */
    public function update(Request $request, int $id): Response
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form = $this->createFormBuilder($article)->add('title', TextType::class,
            ['attr' => ['class' => 'form-control']])->add('body', TextareaType::class,
            ['required' => 'false', 'attr' => ['class' => 'form-control']])->add('save', SubmitType::class,
            ['label' => "Update", 'attr' => ['class' => 'btn btn-primary mt-3']])->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->flush();

            return $this->redirectToRoute("article_list");
        }

        return $this->render("/articles/update.html.twig", ['form' => $form->createView()]);
    }


}