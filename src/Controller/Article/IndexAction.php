<?php

declare(strict_types=1);

namespace App\Controller\Article;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Twig\Environment;

final class IndexAction
{
    private ArticleRepository $articleRepository;
    private Environment $twig;

    public function __construct(
        ArticleRepository $articleRepository,
        Environment       $twig
    )
    {
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
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