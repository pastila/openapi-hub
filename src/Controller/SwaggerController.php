<?php

namespace App\Controller;

use App\Entity\OpenApiDoc;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SwaggerController extends AbstractController
{
  private $doctrine;
  private $serializer;

  public function __construct (
    ManagerRegistry $doctrine,
    SerializerInterface $serializer
  )
  {
    $this->doctrine = $doctrine;
    $this->serializer = $serializer;
  }

  /**
   * @Route("/api/{id}", name="api_show", requirements={"id"="\d+"})
   */
  public function showAction (Request $request, $id)
  {
    $api = $this->doctrine->getRepository(OpenApiDoc::class)->findOneBy(['id' => $id]);

    if ($api === null)
    {
      throw new NotFoundHttpException();
    }

    return $this->render('swagger/show.html.twig', [
      'api' => $api,
    ]);
  }

  /**
   * @Route("/api/{id}/edit", name="api_edit", requirements={"id"="\d+"})
   */
  public function editAction (Request $request, $id)
  {
    $api = $this->doctrine->getRepository(OpenApiDoc::class)->findOneBy(['id' => $id]);

    if ($api === null)
    {
      throw new NotFoundHttpException();
    }

    return $this->render('swagger/edit.html.twig', [
      'api' => $api,
    ]);
  }

  /**
   * @Route("/api/{id}.yaml", name="app_yaml_show", methods={"GET"})
   */
  public function yamlAction (Request $request, $id): Response
  {
    $api = $this->doctrine->getRepository(OpenApiDoc::class)->findOneBy(['id' => $id]);

    if ($api === null)
    {
      throw new NotFoundHttpException();
    }

    return new Response($api->getBody());
  }

  /**
   * @Route("/api/{id}.yaml", name="app_yaml_save", methods={"POST"})
   */
  public function saveAction (Request $request, $id): Response
  {
    $api = $this->doctrine->getRepository(OpenApiDoc::class)->findOneBy(['id' => $id]);

    if ($api === null)
    {
      throw new NotFoundHttpException();
    }

    $body = $request->getContent();
    $api->setBody($body);
    $this->doctrine->getManager()->persist($api);
    $this->doctrine->getManager()->flush();

    return new Response();
  }
}
