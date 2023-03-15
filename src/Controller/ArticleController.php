<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository){
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/article/add', name: 'article_add', methods: ['GET', 'POST'])]
    public function add(Request $request):Response
    {
        if (!$this->isGranted('ROLE_AUTHOR'))
        {
            return $this->redirectToRoute('home');
        }

        $article = new Article();
        $article->setAuthor($this->getUser());
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request); #hydrate the article object

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($this->userRepository->find($this->getUser()->getUserIdentifier()));
            $published = $form->get('submit')->isClicked();
            $article->setIsPublished($published);

            $this->entityManager->persist($article); #consider my new article
            $this->entityManager->flush(); #send my article to the database
            $this->addFlash('success', "L'article a bien été ajouté");

            return $this->redirectToRoute('home');
        }

        return $this->render('article/add.html.twig', [
           'article_form' => $form->createView(),
        ]);
    }

    #[Route('article/edit/{id}', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Article $article, Request $request): Response
    {
        if (!$this->isGranted('ROLE_AUTHOR') || $this->getUser() !== $article->getAuthor())
        {
            return $this->render('home/index.html.twig');
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $published = $form->get('submit')->isClicked();
            $article->setIsPublished($published);

            $this->entityManager->flush();
            $this->addFlash('success', "L'article a bien été mise à jour");

            return $this->redirectToRoute('home');
        }

        return $this->render('article/add.html.twig', [
            'article_form'=> $form->createView(),
        ]);
    }

    #[Route('article/delete/{id}', name: 'article_delete', methods: ['GET', 'DELETE'])]
    public function delete(Article $article, EntityManagerInterface $entityManager): Response
    {

        if (!$this->isGranted('ROLE_AUTHOR') || $this->getUser() !== $article->getAuthor())
        {
            return $this->render('home/index.html.twig');
        }
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute("home");
    }

}
