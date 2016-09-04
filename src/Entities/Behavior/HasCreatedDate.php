<?php

namespace HelpMeAbstract\Entities\Behavior;

trait HasCreatedDate
{
    private $createdDate;

    public function updateCreatedDate()
    {
        if ($this->createdDate === null) {
            $this->createdDate = new \DateTime();
        }
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate() :\DateTime
    {
        return $this->createdDate;
    }
}