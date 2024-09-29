<?php

namespace App\Controller;

use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class IndexController extends AbstractController
{

  private $em;//entity manager

  //Connect to the entries for posts
  private $postRepository;

  public function __construct(PostRepository $postRepository, EntityManagerInterface $em )
  {
    $this->postRepository = $postRepository;
    $this->em = $em;

  }

  #[Route('/', methods: ['GET'], name: 'index')]
  public function index(Request $request): Response
  {
    //Display the 5 most recent published articles
    $posts = $this->postRepository->createQueryBuilder('p')
    ->where('p.Published = :Published')
    ->setParameter('Published', true)
    ->orderBy('p.createdAt', 'DESC')
    ->setMaxResults(5)
    ->getQuery()
    ->getResult();

    return $this->render('index.html.twig',
      [
        'posts' => $posts
      ]);
  }

  #[Route('about/', methods: ['GET'], name: 'about')]
  public function about(): Response 
  {
    return $this->render('about.html.twig');
  }

  #[Route('contact/', methods: ['GET'], name: 'contact')]
  public function contact(): Response 
  {
    return $this->render('contact.html.twig');
  }
}