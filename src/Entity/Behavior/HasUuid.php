<?php


namespace HelpMeAbstract\Entity\Behavior;

use Ramsey\Uuid\Uuid;

trait HasUuid
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @var Uuid
     */
    protected $id;

    /**
     * @return Uuid
     */
    public function getId()
    {
        return $this->id;
    }
}