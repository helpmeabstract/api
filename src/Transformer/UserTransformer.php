<?php

namespace HelpMeAbstract\Transformer;

use HelpMeAbstract\Entity\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user) : array
    {
        return [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'twitterHandle' => $user->getTwitterHandle(),
            'githubHandle' => $user->getGithubHandle(),
            'timesPreviouslySpoken' => $user->getTimesPreviouslySpoken(),
            'primaryTechnicalLanguage' => $user->getPrimaryTechnicalLanguage(),
            'primarySpoken_language' => $user->getPrimarySpokenLanguage(),
            'location' => $user->getLocation(),
            'gender' => $user->getGender(),
            'ageRange' => $user->getAgeRange(),
        ];
    }
}
