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

class AdminController extends AbstractController
{
    private $em;//entity manager

    //Connect to the entries for teachers in the DB
    private $userRepository;
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em )
    {
        $this->userRepository = $userRepository;
        $this->em = $em;

    }

    //Index
    #[Route('/admin', name: 'admin_index')]
    public function adminIndex(Request $request): Response
    {
      return $this->render('admin/admin_index.html.twig');
      
    }

    //Create
    #[Route('/admin/user/create', name: 'create_user')]
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
    /*
    //UPDATE (edit)
    #[Route('teachers/edit/{id}', name: 'edit_teachers')]
    public function edit($id, Request $request): Response
    {
      $teacher = $this->teacherRepository->find($id);

      $form = $this->createForm(TeacherFormType::class, $teacher);

      $form->handleRequest($request);
      $imagePath = $form->get('imagePath')->getData();

      //Handle when a new image is uploaded (or not)

      //Check whether form has been submitted
      if ($form->isSubmitted() && $form->isValid()) {
        if ($imagePath) {
          if ($teacher->getImagePath() !== null) {
            if (file_exists(
                  $this->getParameter('kernel.project_dir') . '/public/' . $teacher->getImagePath()
                )) {
             
              
                $this->getParameter('kernel.project_dir') . '/public/' .  $teacher->getImagePath();

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
    
                $teacher->setImagePath('/uploads/' . $newFileName);

                $this->em->flush();

                return $this->redirectToRoute('teachers');
              } 
            }
        } else {
          //Persist the title etc as image is unchanged
          $teacher->setFirstName($form->get('firstName')->getData());
          $teacher->setLastName($form->get('lastName')->getData());

          $this->em->flush();

          return $this->redirectToRoute('teachers');
        }
      }

        return $this->render('teachers/edit.html.twig', [
          'teacher' => $teacher,
          'form' => $form->createView()
        ]);
    }
    */
      // READ all users
    #[Route('/admin/users', methods:['GET'], name: 'all_users')]
    public function index(): Response
    {
        $users =  $this->userRepository->findAll();

        return $this->render('admin/users_index.html.twig', [
            'users' => $users
            
        ]);

    }
    /*
    // READ one
    #[Route('/teachers/{id}', methods:['GET'], name: 'teacher')]
    public function show($id): Response
    {
        $teacher =  $this->teacherRepository->find($id);

        return $this->render('teachers/show.html.twig', [
            'teacher' => $teacher
        ]);

    }


    //Delete
    #[Route('/teachers/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_teacher')]
    public function delete($id): Response
    {
      $teacher = $this->teacherRepository->find($id);
      $this->em->remove($teacher);
      $this->em->flush();
      return $this->redirectToRoute('teachers');

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
