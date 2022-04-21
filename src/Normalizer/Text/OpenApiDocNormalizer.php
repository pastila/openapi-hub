<?php

namespace App\Normalizer\Text;

use App\Entity\OpenApiDoc;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Yaml\Yaml;

class OpenApiDocNormalizer implements NormalizerInterface
{
  /**
   * @param OpenApiDoc $object
   * @param string|null $format
   * @param array $context
   * @return array
   */
  public function normalize ($object, string $format = null, array $context = [])
  {
    $body = $object->getBody();
    $data = Yaml::parse($body);

    return [
      'id' => $object->getId(),
      'title' => $object->getTitle(),
      'body' => json_encode($data),
    ];
  }

  public function supportsNormalization ($data, string $format = null)
  {
    return $data instanceof OpenApiDoc;
  }

}