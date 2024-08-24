<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UsersController extends AbstractController
{
    private $em;//entity manager

    //Connect to the entries for users in the DB
    private $userRepository;
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em )
    {
        $this->userRepository = $userRepository;
        $this->em = $em;

    }

    // No create as it is found in admin

    //UPDATE (edit)
    #[Route('users/edit/{id}', name: 'edit_users')]
    public function edit($id, Request $request): Response
    {
      $user = $this->userRepository->find($id);

      $form = $this->createForm(userFormType::class, $user);

      $form->handleRequest($request);
      

      $this->em->flush();

      // return $this->redirectToRoute('profile');
           
      return $this->render('users/edit.html.twig', [
          'user' => $user,
          'form' => $form->createView()
        ]);
    }
    
      // READ all
    #[Route('/users', methods:['GET'], name: 'users')]
    public function index(): Response
    {
        $users =  $this->userRepository->findAll();

        return $this->render('users/index.html.twig', [
            'users' => $users
        ]);

    }

    // READ one
    #[Route('/users/{id}', methods:['GET'], name: 'profile')]
    public function show($id): Response
    {
        $user =  $this->userRepository->find($id);

        return $this->render('users/profile.html.twig', [
            'user' => $user
        ]);

    }


    //Delete
    #[Route('/users/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_user')]
    public function delete($id): Response
    {
      $user = $this->userRepository->find($id);
      $this->em->remove($user);
      $this->em->flush();
      return $this->redirectToRoute('users');

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
