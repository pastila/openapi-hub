<?php

namespace App\Form\Common;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageType extends VichImageType
{
  public function buildForm (FormBuilderInterface $builder, array $options): void
  {
    parent::buildForm($builder, $options);
    $builder->addEventListener(FormEvents::SUBMIT, [$this, 'onSubmit']);
  }

  public function configureOptions (OptionsResolver $resolver): void
  {
    parent::configureOptions($resolver);
    $resolver->setDefault('constraints', [
    ]);
  }

  /*
   * Полем для загрузки мы указываем поле, которое не является колонкой
   * Если мы сабмитем только новую картинку, то doctrine не находит изменений в сущности и не пытается её обновить
   * Из-за этого не вызывает слушатель на обновление, который загружает файл и записывает название файла в поле
   *
   * Поэтому при загрузке нового файла - мы берем поле, в котором хранится имя файла и переписываем его - это вызывает триггер при успешном сабмите формы
   */
  public function onSubmit (FormEvent $event)
  {
    $data = $event->getData();

    if ($data && $data['file'] instanceof UploadedFile
      && $event->getForm()->getParent()
      && is_object($event->getForm()->getParent()->getData()))
    {
      $entity = $event->getForm()->getParent()->getData();
      $fieldName = $event->getForm()->getName();

      if (strpos($fieldName, '__') !== false)
      {
        $path = explode('__', $fieldName);
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($path as $i => $item)
        {
          if (($i + 1) === count($path))
          {
            $fieldName = $item;
            continue;
          }

          $entity = $accessor->getValue($entity, $item);
        }
      }


      $mapping = $this->factory->fromField($entity, $fieldName);
      $property = $mapping->getFileNamePropertyName();
      $this->propertyAccessor->setValue($entity, $property, $data['file']->getPathname());
    }
  }
}