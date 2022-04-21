<?php

namespace App\Admin;

use App\Form\Common\ImageType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OpenApiDocAdmin extends AbstractAdmin
{
  protected function configureListFields (ListMapper $list): void
  {
    $list
      ->add('title')
      ->add(ListMapper::NAME_ACTIONS, null, [
        'actions' => [
          'edit' => [],
        ],
      ]);
  }

  protected function configureFormFields (FormMapper $form): void
  {
    $form
      ->add('title', TextType::class, [
        'required' => true,
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('description', TextareaType::class, [
        'required' => false,
      ])
      ->add('imageFile', ImageType::class, [
        'required' => false,
      ])
    ;
  }

  protected function configureRoutes (RouteCollectionInterface $collection): void
  {
    parent::configureRoutes($collection);
    $collection->remove('delete');
  }
}