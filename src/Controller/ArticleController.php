<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/article/add', name: 'article_add')]
    public function add(Request $request, EntityManagerInterface $entityManager):Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request); #hydrate the article object

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article); #consider my new article
            $entityManager->flush(); #send my article to the database
        }

        return $this->render('article/add.html.twig', [
           'article_form' => $form->createView(),
        ]);
    }


}
