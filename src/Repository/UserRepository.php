<?php

namespace HelpMeAbstract\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getVolunteers()
    {
        return $this->findBy(['type' => 'volunteer']);
    }
}
