<?php

declare(strict_types=1);

namespace App\Controller\Article;

use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Twig\Environment;

final class IndexAction
{
    private ArticleRepository $articleRepository;
    private Environment $twig;
    private AuthorRepository $authorRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        Environment       $twig,
        AuthorRepository $authorRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
        $this->authorRepository = $authorRepository;
    }

    /**
     * @Route("/", name="article_list")
     * @Method({"GET"})
     */
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();


        return new Response($this->twig->render('articles/index.html.twig', ['articles' => $articles]));
    }
}