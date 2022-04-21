<?php

namespace App\Voter;

use App\Entity\OpenApiDoc;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ApiVoter extends Voter
{
  const EDIT = 'api_edit';

  protected function supports (string $attribute, $subject)
  {
    return in_array($attribute, [self::EDIT])
      && $subject instanceof OpenApiDoc;
  }

  protected function voteOnAttribute (string $attribute, $subject, TokenInterface $token)
  {
    if ($attribute === self::EDIT)
    {

    }

    return true;
  }

}