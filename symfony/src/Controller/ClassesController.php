<?php

namespace App\Controller;

use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ClassesController extends AbstractController
{
    #[Route('/classes', name: 'app_classes')]
    public function index(): Response
    {
        $classes = ['Year 10 Maths Core',
          'Year 12 English', 
          'Year 7 Japanese'
        ];

        return $this->render('index.html.twig', array(
          'classes'  => $classes
        ));

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
