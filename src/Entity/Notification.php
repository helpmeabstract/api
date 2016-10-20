<?php

namespace HelpMeAbstract\Entity;

use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Behavior\HasCreatedDate;
use HelpMeAbstract\Entity\Behavior\HasId;
use HelpMeAbstract\Entity\Notification\Subject;

/**
 * @ORM\Entity(repositoryClass="HelpMeAbstract\Repository\NotificationRepository")
 * @ORM\Table( name="notifications")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "comment" = "HelpMeAbstract\Entity\Notification\CommentNotification",
 *     "submission" = "HelpMeAbstract\Entity\Notification\SubmissionNotification"
 * })
 *
 * @ORM\HasLifecycleCallbacks
 */
abstract class Notification
{
    use HasId;
    use HasCreatedDate;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     name="has_been_read",
     *     options={"default":false}
     * )
     *
     * @var bool
     */
    private $hasBeenRead = false;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     name="date_read"
     * )
     *
     * @var \DateTime
     */
    private $dateRead;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     name="has_been_sent",
     *     options={"default":false}
     * )
     *
     * @var bool
     */
    private $hasBeenSent = false;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     name="date_sent"
     * )
     *
     * @var \DateTime
     */
    private $dateSent;

    /**
     * @var User
     */
    private $user;

    /**
     * @var resource
     */
    private $subject;

    /**
     * @param User    $user
     * @param Subject $subject
     */
    public function __construct(User $user, Subject $subject)
    {
        $this->user = $user;
        $this->subject = $subject;
    }

    public function markRead()
    {
        $this->hasBeenRead = true;
        $this->dateRead = new \DateTime();
    }

    public function markUnread()
    {
        $this->hasBeenRead = false;
        $this->dateRead = null;
    }

    public function markSent()
    {
        $this->hasBeenSent = true;
        $this->dateSent = new \DateTime();
    }
}
