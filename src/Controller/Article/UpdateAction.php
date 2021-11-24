<?php
declare(strict_types=1);

namespace App\Controller\Article;


use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class UpdateAction
{
    private $twig;
    private $entityManager;
    private $formFactory;
    private $articleRepository;
    private $router;

    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        ArticleRepository $articleRepository,
        RouterInterface $router
    )
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->articleRepository = $articleRepository;
        $this->router = $router;
    }

    /**
     * @Route("/article/update/{id}", name="update_article")
     * @Method({"GET","POST"})
     */
    public function update(Request $request, int $id): Response
    {

        $article = $this->articleRepository->find($id);

       $form = $this->formFactory->create(ArticleFormType::class,$article);
       $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

           $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('article_list'));
        }

        return new Response($this->twig->render("/articles/update.html.twig", ['form' => $form->createView()]));
    }

}