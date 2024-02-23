<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\MainArticle;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\MainArticleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/article')]
#[IsGranted('VOTER_ADMIN', statusCode: 403, message: 'Vous n\'avez pas les droits pour accéder à cette page')]
class AdminArticleController extends AbstractController
{
    #[Route('/index/{status}', name: 'app_admin_article_index', methods: ['GET'], defaults: ['status' => null])]
    public function index(
        string $status = null,
        ArticleRepository $articleRepository,
        MainArticleRepository $mainARepository
    ): Response {
        $mainArticle = $mainARepository->findAll();

        if (empty($mainArticle)) {
            $mainArticleId = null;
        } else {
            $mainArticleId = $mainArticle[0]->getArticle()->getId();
        }

        $status = match ($status) {
            'archived' => '3',
            'published' => '2',
            'draft' => '1',
            default => null,
        };

        if (isset($status)) {
            $articles = $articleRepository->findBy(['status' => $status]);
        } else {
            $articles = $articleRepository->findAll();
        }
        return $this->render('admin/article/index.html.twig', [
            'articles' => $articles,
            'filterStatus' => $status ?? null,
            'page' => 'articles',
            'mainArticleId' => $mainArticleId,
        ]);
    }

    #[Route('/new', name: 'app_admin_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setReleaseDate(new DateTime());
            $article->setUpdatedAt(new DateTime());
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('sucess', 'Votre article a bien été créé');

            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form,
            'page' => 'new'
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('admin/article/show.html.twig', [
            'article' => $article,
            'page' => 'show'
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new DateTime());
            $entityManager->flush();

            $this->addFlash('success', 'Votre article a bien été mis à jour');

            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
            'page' => 'edit'
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_delete', methods: ['GET', 'POST'])]
    public function delete(
        Request $request,
        Article $article,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(
        '/main/{id}/filter/{filter}',
        name: 'app_admin_article_setmain',
        methods: ['GET', 'POST'],
        defaults: ['filter' => null]
    )]
    public function setMain(
        Article $article,
        string $filter = null,
        MainArticleRepository $mainARepository,
        EntityManagerInterface $entityManager
    ): Response {
        $currentMainArticle = $mainARepository->findAll();

        if (empty($currentMainArticle[0])) {
            $currentMainArticle = new MainArticle();
            $currentMainArticle->setArticle($article);
            $entityManager->persist($currentMainArticle);
        } else {
            $currentMainArticle[0]->setArticle($article);
        }

        $entityManager->flush();

        if ($filter === null) {
            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        $filter = match ($filter) {
            '3' => 'archived',
            '2' => 'published',
            default => null,
        };

        return $this->redirectToRoute('app_admin_article_index', ['status' => $filter], Response::HTTP_SEE_OTHER);
    }
}
