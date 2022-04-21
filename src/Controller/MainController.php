<?php

namespace App\Controller;

use App\Entity\OpenApiDoc;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
  private $doctrine;

  public function __construct (ManagerRegistry $doctrine)
  {
    $this->doctrine = $doctrine;
  }

  /**
   * @Route(name="homepage", path="/")
   */
  public function homepageAction (Request $request)
  {
    $apis = $this->doctrine->getRepository(OpenApiDoc::class)->findAll();

    return $this->render('main/homepage.html.twig', [
      'apis' => $apis,
    ]);
  }
}