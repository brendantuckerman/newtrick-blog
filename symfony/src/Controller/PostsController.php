<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostFormType; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PostsController extends AbstractController
{
    private $em;//entity manager

    //Connect to the entries for posts in the DB
    private $postRepository;
    public function __construct(postRepository $postRepository, EntityManagerInterface $em )
    {
        $this->postRepository = $postRepository;
        $this->em = $em;

    }

    //CREATE
    #[Route('/admin/posts/create', name: 'create_post')]
    public function create(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(postFormType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $newpost = $form->getData();
         
          //Deal with image paths
          $imagePath = $form->get('imagePath')->getData();
          if ($imagePath) {
            $newFileName = uniqid() . "." . $imagePath->guessExtension();

            try {
              $imagePath->move(
                //Accepts 2 params:
                // Where to look
                $this->getParameter('kernel.project_dir') . '/public/uploads',
                //New file name
                $newFileName
              );
            } catch  (FileException $e){
              return new Response($e->getMessage());
            }

            $post->setImagePath('/uploads/' . $newFileName);

          }

          // Ensure tags are set correctly
          $tags = $form->get('tags')->getData();
          $newpost->setTags($tags);

          

          $this->em->persist($newpost);
          $this->em->flush();

          return $this->redirect('/posts');

        }

        return $this->render('posts/create.html.twig', [
            'form' => $form->createView()
        ]);

    }

    //UPDATE (edit)
    #[Route('admin/posts/edit/{id}', name: 'edit_posts')]
    public function edit($id, Request $request): Response
    {
      $post = $this->postRepository->find($id);

      $form = $this->createForm(postFormType::class, $post);


      $form->handleRequest($request);
      $imagePath = $form->get('imagePath')->getData();

      //Handle when a new image is uploaded (or not)

      //Check whether form has been submitted
      if ($form->isSubmitted() && $form->isValid()) {
          if ($imagePath) {
            if ($post->getImagePath() !== null) { //this is the test that is failing
                if (file_exists(
                    $this->getParameter('kernel.project_dir') . '/public/' . $post->getImagePath()
                    )) {
             
                    $this->getParameter('kernel.project_dir') . '/public/' .  $post->getImagePath();
                    } 
                }
            //Give image a unique id
            $newFileName = uniqid() . "." .$imagePath->guessExtension();

            //Upload the image
            try {
                $imagePath->move(
                //Accepts 2 params:
                // Where to look
                $this->getParameter('kernel.project_dir') . '/public/uploads',
                //New file name
                $newFileName
                );
            } catch  (FileException $e){
                return new Response($e->getMessage());
            }

            $post->setImagePath('/uploads/' . $newFileName);

            $this->em->flush();

            return $this->redirectToRoute('posts');
             
        } else {
          //Persist the title etc as image is unchanged
          $post->setTitle($form->get('title')->getData());
          $post->setContent($form->get('content')->getData());
          $post->setTags($form->get('tags')->getData());
          $post->setPublished($form->get('published')->getData());

          $this->em->flush();

          return $this->redirectToRoute('posts');
        }
      }

        return $this->render('posts/edit.html.twig', [
          'post' => $post,
          'form' => $form->createView()
        ]);
    }
    
      // READ all
    #[Route('/posts', methods:['GET'], name: 'posts')]
    public function index(): Response
    {
        $posts =  $this->postRepository->findAll();

        return $this->render('posts/index.html.twig', [
            'posts' => $posts
        ]);

    }

    // READ one (Show)
    #[Route('/posts/show/{year}/{slug}', methods:['GET'], name: 'post')]
    public function show(int $year, string $slug): Response
    {
        $post = $this->postRepository->findOneBy(['slug' => $slug]);

        if (!$post || $post->getCreatedAt()->format('Y') != $year) {
            throw $this->createNotFoundException('The post does not exist');
        }

        return $this->render('posts/show.html.twig', [
            'post' => $post,
        ]);

    }


    //Delete
    #[Route('admin/posts/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_post')]
    public function delete($id): Response
    {
      $post = $this->postRepository->find($id);
      $this->em->remove($post);
      $this->em->flush();
      return $this->redirectToRoute('admin_posts_index');

    }


    /**
     * index
     *
     * @param  mixed $className
     * @return JsonResponse
     * 
     * This was the original function that returns a json repsonse
      */ 
    //#[Route('/classes/{className}', name: 'app_classes', defaults: ['className' => null ], methods:['GET', 'HEAD'])]
    // public function index($className): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to ' . $className,
    //         'path' => 'src/Controller/ClassesController.php',
    //     ]);
    // }
    
}
