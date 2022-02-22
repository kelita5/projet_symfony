<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{
    #[Route('/article/create', name: 'article')]
    public function createArticle(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $article->setCreatedAt(new DateTime());
            $brochureFile = $form->get('brochureFilename')->getData();
            
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $article->setBrochureFilename($newFilename);
                $entityManager->persist($article);
                $entityManager->flush();
            }

            // ... persist the $product variable or any other work
            return $this->redirectToRoute('read_all_article');
        }


        return $this->render('articles/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/article/read-all', name: 'read_all_article')]
    public function readAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Article::class);
        $articles = $repository->findAll();

        return $this->render('articles/readallarticle.html.twig', [
            "articles" => $articles
        ]);
    }
    #[Route('/article/read/{id}', name: 'read_article')]
    public function read(ManagerRegistry $doctrine, Article $article,Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $doctrine->getManager();

                $comment->setArticle($article);
                
                $entityManager->persist($comment);
                $entityManager->flush();
            }

        return $this->render('articles/read.html.twig', [
            "article" => $article,
            "form"=>$form->createView(),
        ]);
    }
    #[Route('/article/edit/{id}', name: 'edit_article')]
    public function edit(Request $request, ManagerRegistry $doctrine, Article $article, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('brochureFilename')->getData();
            
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $article->setBrochureFilename($newFilename);
                $doctrine->getManager()->flush();
            }
            
            return $this->redirectToRoute('read_all_article');
        }
        return $this->render('articles/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }
    #[Route('/article/delete/{id}', name: 'delete_article')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(Article::class);
        $article = $repository->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute("read_all_article");
    }
}
