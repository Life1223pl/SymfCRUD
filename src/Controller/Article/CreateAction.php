<?php
declare(strict_types=1);

namespace App\Controller\Article;


use App\Entity\Article;
use App\Entity\Author;
use App\Form\ArticleFormType;
use App\Form\AuthorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;




class CreateAction
{
    private $formFactory;
    private $twig;
    private $router;
    private $entityManger;

    public function __construct(
        Environment $twig,
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory
    )
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->entityManger = $entityManager;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/article/new", name="new_article")
     * @Method({"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $author = new Author();


        $form = $this->formFactory->create(ArticleFormType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $article->setTitle($form['title']->getData());
            $article->setBody($form['body']->getData());

            $this->entityManger->persist($article);
            $this->entityManger->flush();
            $author->setName($form['authorName']->getData());
            $author->setArticleId($article->getId());
            $this->entityManger->persist($author);
            $this->entityManger->flush();

            return new RedirectResponse($this->router->generate('article_list'));

        }


        return new Response($this->twig->render("/articles/new.html.twig", [
            'form' => $form->createView()
        ]));
    }

}