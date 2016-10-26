<?php

namespace HelpMeAbstract\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Comment;
use HelpMeAbstract\Entity\Notification;

/**
 * @ORM\Entity()
 */
class CommentNotification extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="HelpMeAbstract\Entity\Comment")
     *
     * @var Comment
     */
    protected $subject;
}
