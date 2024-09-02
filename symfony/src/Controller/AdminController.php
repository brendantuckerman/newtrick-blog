<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Form\UserFormType;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends AbstractController
{
    private $em;//entity manager

    //Connect to the entries for users and posts in the DB
    private $userRepository;
    private $postRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository, EntityManagerInterface $em )
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->em = $em;

    }

    //Index
    #[Route('/admin', name: 'admin_index')]
    public function adminIndex(Request $request): Response
    {
      return $this->render('admin/admin_index.html.twig');
      
    }

    //User- create
    #[Route('/admin/users/create', name: 'create_user')]
    public function createUser(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $newUser = $form->getData();
         
          $this->em->persist($newUser);
          $this->em->flush();

          return $this->redirect('/admin/users');

        }

        return $this->render('admin/create_user.html.twig', [
            'form' => $form->createView()
        ]);

    }

    //User -edit
    #[Route('admin/users/{id}', name: 'edit_users')]
    public function edit($id, Request $request): Response
    {
      $user = $this->userRepository->find($id);

      $form = $this->createForm(userFormType::class, $user);

      $form->handleRequest($request);
      
       //Check whether form has been submitted
       if ($form->isSubmitted() && $form->isValid()) {

         $this->em->flush();
         return $this->redirectToRoute('users');
       }

           
      return $this->render('users/edit.html.twig', [
          'user' => $user,
          'form' => $form->createView()
        ]);
    }
    

    /** POSTS **/
    //Posts index
    #[Route('/admin/posts', name: 'admin_posts_index')]
    public function adminPostsIndex(Request $request): Response
    {
      $posts = $this->postRepository->findAll();
    
      return $this->render('admin/posts_index.html.twig',[
        'posts'  => $posts
      ]);
      
    }
    
}
