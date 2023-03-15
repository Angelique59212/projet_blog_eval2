<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CommentsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/comments/add/{id}', name: 'comments_add', methods: ['GET', 'POST'])]
    public function add(Request $request, Article $article): Response
    {
        if (!$this->isGranted('ROLE_USER'))
        {
            $this->redirectToRoute('home');
        }

        $comment = new Comments();
        $comment->setArticle($article)->setUser($this->getUser());

        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($comment);
            $this->entityManager->flush();
            $this->addFlash('success', "Votre commentaire a été ajouté");

            return $this->redirectToRoute('home');
        }

        return $this->render('comments/add.html.twig', [
            'comments_form' => $form->createView()
        ]);
    }


    #[Route('/comments/edit/{id}', name: 'comments_edit', methods: ['GET', 'POST'])]
    public function edit(Comments $comments, Request $request): Response
    {
        if (!$this->isGranted('ROLE_MODERATOR'))
        {
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(CommentsType::class, $comments);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "Commentaire mis à jour");

            return $this->redirectToRoute('home');
        }

        return $this->render('comments/edit.html.twig', [
            'comments_form' => $form->createView()
        ]);
    }

    #[Route('/comments/delete/{id}', name: 'comments_delete', methods: ['GET', 'DELETE'])]
    public function delete(Comments $comments): Response
    {
        if (!$this->isGranted('ROLE_MODERATOR')) {
            return $this->redirectToRoute('home');
        }

        $this->entityManager->remove($comments);
        $this->entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
