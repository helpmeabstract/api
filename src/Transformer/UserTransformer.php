<?php

namespace HelpMeAbstract\Transformer;

use HelpMeAbstract\Entity\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user) : array
    {
        return [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'twitter_handle' => $user->getTwitterHandle(),
            'github_handle' => $user->getGithubHandle(),
            'times_previously_spoken' => $user->getTimesPreviouslySpoken(),
            'primary_technical_language' => $user->getPrimaryTechnicalLanguage(),
            'primary_spoken_language' => $user->getPrimarySpokenLanguage(),
            'location' => $user->getLocation(),
            'gender' => $user->getGender(),
            'age_range' => $user->getAgeRange(),
        ];
    }
}
