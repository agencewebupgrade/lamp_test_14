<?php

namespace App\Controller;

// ADD BY ME
use App\Entity\Blog;
use App\Repository\BlogRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    // DE BASE (sans rien changer ou enlever)
    #[Route('/blog', name: 'blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    // ADD
    #[Route('/blog/add', name: 'blog_add')] // route
    public function blog_add(): Response
    {
        $entityManager = $this->getDoctrine()->getManager(); // Obligatoire

        $blog = new Blog(); // Créer l'objet 
        $blog->setName('trosièmeblog'); //Ajoute l'information, comme défini dans l'entité
        $blog->setDateAdd(new \DateTime()); //Ajoute l'information, comme défini dans l'entité
        $blog->setImage('image3.png'); //Ajoute l'information, comme défini dans l'entité

        $entityManager->persist($blog); // Appeler doctrine
        $entityManager->flush(); //executer la requete pour ajouter la donnée

        return new Response('Un blog sauvegardé avec succès sous l\'id : '.$blog->getId()); // afficher une réponse avec l'id inséré
    }

    // SHOW ONE

        // BEST METHOD 
            /**
             * @Route("/blog/show_best_1/{id}", name="blog_show_best_1")
             */
            public function show_best_1(int $id): Response
            {
                $repository = $this->getDoctrine()->getRepository(Blog::class);
                $blog = $repository->find($id);

                return new Response('Le titre de ce super blog : '.$blog->getName()); // Renvoyer une réponse 
                // Sinon on peut aussi envoyer de l'information à un template de cette façon : return $this->render('blog/show.html.twig', ['blog' => $blog]);
                // Et on peut la recuperer dans le template de cette façon {{ blog.name }}
            }
            // OU
            /**
             * @Route("/blog/show_best_2/{id}", name="blog_show_best_2")
             */
            public function show_best_2(int $id, BlogRepository $blogRepository): Response
            {
                $blog = $blogRepository
                    ->find($id);

                return new Response('Le titre de ce super blog : '.$blog->getName()); // Renvoyer une réponse 
                // Sinon on peut aussi envoyer de l'information à un template de cette façon : return $this->render('blog/show.html.twig', ['blog' => $blog]);
                // Et on peut la recuperer dans le template de cette façon {{ blog.name }}
            }
                  

        // SIMPLE METHOD 
        /**
         * @Route("/blog/show_simple/{id}", name="blog_show_simple")
         */
        public function show_simple(Blog $blog): Response
        {
            return new Response('Le titre de ce super blog : '.$blog->getName()); // Renvoyer une réponse 
            // Sinon on peut aussi envoyer de l'information à un template de cette façon : return $this->render('blog/show.html.twig', ['blog' => $blog]);
            // Et on peut la recuperer dans le template de cette façon {{ blog.name }}
        }

        // CUSTOMIZED METHOD
        /**
         * @Route("/blog/show_customized/{id}", name="blog_show_customized")
         */
        public function show_customized(int $id): Response
        {
            $blog = $this->getDoctrine()
                ->getRepository(Blog::class)
                ->find($id); // Récuperer le référentiel

            if (!$blog) {
                throw $this->createNotFoundException(
                    'Aucun blog trouvé pour l\'id : '.$id
                ); // Générer une erreur si l'id est introuvable
            }

            return new Response('Le titre de ce super blog : '.$blog->getName()); // Renvoyer une réponse 
            // Sinon on peut aussi envoyer de l'information à un template twig de cette façon : return $this->render('blog/show.html.twig', ['blog' => $blog]);
            // Et on peut la recuperer dans le template de cette façon {{ blog.name }}
        }

    // SHOW ONE BY
        /**
         * @Route("/blog/show_one_by/{id}", name="blog_show_one_by")
         */
        public function show_one_by(int $id): Response
        {
            $repository = $this->getDoctrine()->getRepository(Blog::class);
            $blog = $repository->findOneBy([
                'name' => 'deuxièmeblog',
                'date_add' => new \DateTime('2021-08-10 14:11:08'),
            ]);

            return new Response('Le titre de ce super blog : '.$blog->getName()); // Renvoyer une réponse 
            // Sinon on peut aussi envoyer de l'information à un template de cette façon : return $this->render('blog/show.html.twig', ['blog' => $blog]);
            // Et on peut la recuperer dans le template de cette façon {{ blog.name }}
        }

    // SHOW BY
        /**
         * @Route("/blog/show_by/{id}", name="blog_show_by")
         */
        public function show_by(int $id): Response
        {
            $repository = $this->getDoctrine()->getRepository(Blog::class);
            $blog = $repository->findBy(
                ['name' => 'premierblog'],
                ['date_add' => 'ASC']
            );

            return new Response('Le titre de ce super blog : '.print_r($blogs)); // Renvoyer une réponse 
            // Sinon on peut aussi envoyer de l'information à un template de cette façon : return $this->render('blog/show.html.twig', ['blog' => $blog]);
            // Et on peut la recuperer dans le template de cette façon {{ blog.name }}
        }

    // SHOW ALL
        /**
         * @Route("/blog/show_all", name="blog_all")
         */
        public function show_all(): Response
        {
            $repository = $this->getDoctrine()->getRepository(Blog::class);
            $blogs = $repository->findAll();

            return $this->render('blog/show.html.twig', ['blogs' => $blogs]);
        }
}
