<?php

namespace HelpMeAbstract\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Notification;
use HelpMeAbstract\Entity\Submission;

/**
 * @ORM\Entity()
 */
class SubmissionNotification extends Notification
{
    /**
     * @var Submission
     */
    protected $subject;
}
