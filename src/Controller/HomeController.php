<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\MainArticle;
use App\Repository\ArticleRepository;
use App\Repository\MainArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, MainArticleRepository $mainARepository): Response
    {
        $allArticles = $articleRepository->findBy(['status' => '2']);
        $mainArticle = $mainARepository->findOneBy(['id' => '1'])->getArticle();
        $relatedArticles = [];

        $mainArticle = $mainArticle->getStatus() === 2 ? $mainArticle : null;

        if ($mainArticle === null) {
            $mainArticle = $allArticles[0];
            unset($allArticles[0]);
        }

        foreach ($allArticles as $key => $article) {
            if ($article->getId() === $mainArticle->getId()) {
                unset($allArticles[$key]);
            } elseif ($article->getCategory() === $mainArticle->getCategory()) {
                if (count($relatedArticles) < 2) {
                    $relatedArticles[] = $article;
                    unset($allArticles[$key]);
                }
            }
        }

        if (count($relatedArticles) < 1) {
            $relatedArticles = [$allArticles[0], $allArticles[1]];
            unset($allArticles[0], $allArticles[1]);
        } elseif (count($relatedArticles) < 2) {
            $relatedArticles[] = $allArticles[0];
            unset($allArticles[0]);
        }

        return $this->render('home/index.html.twig', [
            'mainArticle' => $mainArticle,
            'allArticles' => $allArticles,
            'relatedArticles' => $relatedArticles,
            'page' => 'home',
        ]);
    }
}
