<?php
declare(strict_types=1);

namespace App\Controller\Article;



use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
final class DeleteAction
{

    private $articleRepository;
    private $entityManager;
    private $router;
    private $authorRepository;
    public function __construct(

        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        RouterInterface $router,
        AuthorRepository $authorRepository
    )
    {

        $this->articleRepository = $articleRepository;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->authorRepository = $authorRepository;

    }

    /**
     * @Route("/article/delete/{id}", name="delete_article")
     */
    public function delete(int $id): RedirectResponse
    {

        $article = $this->articleRepository->find($id);
        $author = $this->authorRepository->findOneBy(['article_id' => $id]);
        $entityManager = $this->entityManager;
        $entityManager->remove($author);
        $entityManager->remove($article);
        $entityManager->flush();

        return new RedirectResponse($this->router->generate('article_list'));
    }

}