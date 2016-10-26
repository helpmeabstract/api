<?php

namespace HelpMeAbstract\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Notification;
use HelpMeAbstract\Entity\Revision;

/**
 * @ORM\Entity()
 */
class RevisionNotification extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="HelpMeAbstract\Entity\Revision")
     *
     * @var Revision
     */
    protected $subject;
}
