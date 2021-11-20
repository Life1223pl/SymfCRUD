<?php
declare(strict_types=1);

namespace App\Controller\Article;



use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
final class DeleteAction
{
    private $twig;
    private $articleRepository;
    private $entityManager;
    private $router;
    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        RouterInterface $router
    )
    {
        $this->twig = $twig;
        $this->articleRepository = $articleRepository;
        $this->entityManager = $entityManager;
        $this->router = $router;

    }

    /**
     * @Route("/article/delete/{id}", name="delete_article")
     */
    public function delete(int $id): RedirectResponse
    {
        $article = $this->articleRepository->find($id);
        $entityManager = $this->entityManager;
        $entityManager->remove($article);
        $entityManager->flush();

        return new RedirectResponse($this->router->generate('article_list'));
    }

}