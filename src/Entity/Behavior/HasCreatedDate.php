<?php

namespace HelpMeAbstract\Entity\Behavior;

trait HasCreatedDate
{
    /**
     * @ORM\Column(
     *     type="datetime",
     *     name="created",
     *     nullable=false
     * )
     *
     * @var \DateTime
     */
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
