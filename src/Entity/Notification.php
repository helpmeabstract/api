<?php

namespace HelpMeAbstract\Entity;

use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Behavior\HasCreatedDate;
use HelpMeAbstract\Entity\Behavior\HasUuid;
use HelpMeAbstract\Entity\Notification\Subject;

/**
 * @ORM\Entity(repositoryClass="HelpMeAbstract\Repository\NotificationRepository")
 * @ORM\Table( name="notifications")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "comment" = "HelpMeAbstract\Entity\Notification\CommentNotification",
 *     "submission" = "HelpMeAbstract\Entity\Notification\SubmissionNotification",
 *     "revision" = "HelpMeAbstract\Entity\Notification\RevisionNotification"
 * })
 *
 * @ORM\HasLifecycleCallbacks
 */
abstract class Notification
{
    const STATUS_PENDING = 'pending';
    const STATUS_QUEUED = 'queued';
    const STATUS_SENT = 'sent';
    const STATUS_READ = 'read';

    use HasUuid;
    use HasCreatedDate;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     name="date_sent",
     *     nullable=true
     * )
     *
     * @var \DateTime
     */
    protected $dateSent;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     name="date_read",
     *     nullable=true
     * )
     *
     * @var \DateTime
     */
    protected $dateRead;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     *
     * @var string
     */
    protected $status = self::STATUS_PENDING;

    /**
     * @ORM\ManyToOne(targetEntity="HelpMeAbstract\Entity\User", inversedBy="notifications")
     *
     * @var User
     */
    protected $recipient;

    /**
     * @param User    $user
     * @param Subject $subject
     */
    public function __construct(User $user, Subject $subject)
    {
        $this->recipient = $user;
        $this->subject = $subject;
    }

    public function markRead()
    {
        $this->dateRead = new \DateTime();
        $this->status = self::STATUS_READ;
    }

    public function markUnread()
    {
        $this->dateRead = null;
        $this->status = self::STATUS_SENT;
    }

    public function markSent()
    {
        $this->dateSent = new \DateTime();
        $this->status = self::STATUS_SENT;
    }

    public function markQueued()
    {
        $this->status = self::STATUS_QUEUED;
    }

    /**
     * @return Subject
     */
    public function getSubject() : Subject
    {
        return $this->subject;
    }

    /**
     * @return User
     */
    public function getRecipient() : User
    {
        return $this->recipient;
    }

    /**
     * @return \DateTime
     */
    public function getDateSent():\DateTime
    {
        return $this->dateSent;
    }

    /**
     * @return \DateTime
     */
    public function getDateRead():\DateTime
    {
        return $this->dateRead;
    }

    /**
     * @return string
     */
    public function getStatus() :string
    {
        return $this->status;
    }
}
