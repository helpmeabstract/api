<?php

namespace HelpMeAbstract\Entities\Behavior;

trait HasId
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}