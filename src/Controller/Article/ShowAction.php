<?php
declare(strict_types=1);

namespace App\Controller\Article;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AuthorRepository;


final class ShowAction
{
    private $articleRepository;
    private $twig;
    private $doctrine;
    private $repository;
    private $authorRepository;


    public function __construct(
        Environment $twig,
        ArticleRepository $articleRepository,
        EntityManagerInterface $doctrine,
        AuthorRepository $authorRepository

    )
    {
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
        $this->doctrine = $doctrine;
        $this->authorRepository = $authorRepository;
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(int $id){
        $article = $this->articleRepository->find($id);
        $author = $this->authorRepository->findOneBy(['article_id' => $id]);
        return new Response($this->twig->render('articles/show.html.twig',[
            'article' => $article,
            'author' => $author

        ]));
    }


}



