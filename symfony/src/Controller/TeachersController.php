<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherFormType;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class TeachersController extends AbstractController
{
    private $em;//entity manager

    //Connect to the entries for teachers in the DB
    private $teacherRepository;
    public function __construct(TeacherRepository $teacherRepository, EntityManagerInterface $em )
    {
        $this->teacherRepository = $teacherRepository;
        $this->em = $em;

    }

    //CREATE
    #[Route('teachers/create', name: 'create_teacher')]
    public function create(Request $request): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherFormType::class, $teacher);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $newTeacher = $form->getData();
         
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

            $teacher->setImagePath('/uploads/' . $newFileName);

          }

          $this->em->persist($newTeacher);
          $this->em->flush();

          return $this->redirect('/teachers');


        }

        return $this->render('teachers/create.html.twig', [
            'form' => $form->createView()
        ]);

    }

    //UPDATE (edit)
    #[Route('teachers/edit/{id}', name: 'edit_teachers')]
    public function edit($id): Response
    {
      $teacher = $this->teacherRepository->find($id);

      $form = $this->createForm(TeacherFormType::class, $teacher);

      return $this->render('teachers/edit.html.twig', [
        'teacher' => $teacher,
        'form' => $form->createView()
      ]);
    }

    // READ all
    #[Route('/teachers', methods:['GET'], name: 'teachers')]
    public function index(): Response
    {
        $teachers =  $this->teacherRepository->findAll();

        return $this->render('teachers/index.html.twig', [
            'teachers' => $teachers
        ]);

    }

    // READ one
    #[Route('/teachers/{id}', methods:['GET'], name: 'teacher')]
    public function show($id): Response
    {
        $teacher =  $this->teacherRepository->find($id);

        return $this->render('teachers/show.html.twig', [
            'teacher' => $teacher
        ]);

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
