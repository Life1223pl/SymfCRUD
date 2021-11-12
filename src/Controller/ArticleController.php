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
     * @Route("/article/new", name="new_article")
     * @Method({"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)->add('title', TextType::class,
            ['attr' => ['class' => 'form-control']])->add('body', TextareaType::class,
            ['required' => 'false', 'attr' => ['class' => 'form-control']])->add('save', SubmitType::class,
            ['label' => "Create", 'attr' => ['class' => 'btn btn-primary mt-3']])->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($article);
            $entityManger->flush();

            return $this->redirectToRoute("article_list");
        }

        return $this->render("/articles/new.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(int $id): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render("articles/show.html.twig", ['article' => $article]);
    }

    /**
     * @Route("/article/delete/{id}", name="delete_article")
     */
    public function delete(int $id): RedirectResponse
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute("article_list");
    }

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