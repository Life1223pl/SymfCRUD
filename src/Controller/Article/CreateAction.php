<?php
declare(strict_types=1);

namespace App\Controller\Article;


use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;




class CreateAction
{
    private $FormBuilderInterface;
    private $twig;
    private $router;
    private $entityManger;
    public function __construct(
        FormBuilderInterface $FormBuilderInterface,
        Environment $twig,
        RouterInterface $router,
        EntityManagerInterface $entityManager
    )
    {
        $this->twig = $twig;
        $this->FormBuilderInterface = $FormBuilderInterface;
        $this->router = $router;
        $this->entityManger = $entityManager;

    }

    /**
     * @Route("/article/new", name="new_article")
     * @Method({"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();



        $form = $this->FormBuilderInterface->add('title', TextType::class,
            ['attr' => ['class' => 'form-control']])->add('body', TextareaType::class,
            ['required' => 'false', 'attr' => ['class' => 'form-control']])->add('save', SubmitType::class,
            ['label' => "Create", 'attr' => ['class' => 'btn btn-primary mt-3']])->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $this->entityManger->persist($article);
            $this->entityManger->flush();

            return new RedirectResponse($this->router->generate('article_list'));

        }

        return new Response($this->twig->render("/articles/new.html.twig", ['form' => $form->createView()]));
    }

}