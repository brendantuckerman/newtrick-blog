<?php

namespace App\Controller;

use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TeacherRepository;


class TeachersController extends AbstractController
{

    //Connect to the entries for teachers in the DB
    private $teacherRepository;
    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;

    }

    // Show all
    #[Route('/teachers', methods:['GET'], name: 'teachers')]
    public function index(): Response
    {
        $teachers =  $this->teacherRepository->findAll();

        return $this->render('teachers/index.html.twig', [
            'teachers' => $teachers
        ]);

    }

    // Show one
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
