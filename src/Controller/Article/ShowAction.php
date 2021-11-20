<?php
declare(strict_types=1);

namespace App\Controller\Article;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;


final class ShowAction
{
    private $articleRepository;
    private $twig;
    private $doctrine;
    private $repository;


    public function __construct(
        Environment $twig,
        ArticleRepository $articleRepository,
        EntityManagerInterface $doctrine

    )
    {
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(int $id){
        $article = $this->articleRepository->find($id);
        return new Response($this->twig->render('articles/show.html.twig',['article' => $article]));
    }


}



