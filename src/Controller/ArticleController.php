<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article', name: 'app_article_')]
class ArticleController extends AbstractController
{
    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['article-id' => '\d+'])]
    public function show(
        #[MapEntity(mapping: ['id' => 'id'])] Article $article
    ): Response {
        // TODO à rajouter quand la connexion sera gérée
        //  && !$this->user
        if ($article->getStatus() != '2') {
            throw $this->createNotFoundException('The article does not exist');
        }

        $author = $article->getAuthor();

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'author' => $author,
            'page' => 'article'
        ]);
    }
}
