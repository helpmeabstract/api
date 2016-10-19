<?php

namespace HelpMeAbstract\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use HelpMeAbstract\Entity\Behavior\HasId;

class User
{
    const TYPE_USER = 'user';
    const TYPE_ADMIN = 'admin';
    const TYPE_VOLUNTEER = 'volunteer';

    use HasId;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $twitterHandle;

    /**
     * @var string
     */
    private $githubHandle;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $notificationChannelPreference;

    /**
     * @var string
     */
    private $notificationFrequencyPreference;

    /**
     * @var bool
     */
    private $showProfile;

    /**
     * @var ArrayCollection
     */
    private $comments;

    /**
     * @var ArrayCollection
     */
    private $submissions;

    private function __construct($type = null)
    {
        $this->type = $type ?: self::TYPE_USER;
        $this->comments = new ArrayCollection();
        $this->submissions = new ArrayCollection();
    }

    public function getReviews()
    {
        return $this->comments->filter(function (Comment $comment) {
            return $comment->getUser()->getId() !== $this->getId();
        });
    }

    public function isVolunteer()
    {
        return $this->type == self::TYPE_VOLUNTEER;
    }

    public function isAdmin()
    {
        return $this->type == self::TYPE_ADMIN;
    }

    public function promoteToVolunteer()
    {
        $this->type = self::TYPE_VOLUNTEER;
    }

    public function promoteToAdmin()
    {
        $this->type = self::TYPE_ADMIN;
    }

    public function removeFromVolunteerPool()
    {
        $this->type = self::TYPE_USER;
    }

    /**
     * @param string $notificationChannelPreference
     */
    public function setNotificationChannelPreference($notificationChannelPreference)
    {
        $this->notificationChannelPreference = $notificationChannelPreference;
    }

    /**
     * @param string $notificationFrequencyPreference
     */
    public function setNotificationFrequencyPreference($notificationFrequencyPreference)
    {
        $this->notificationFrequencyPreference = $notificationFrequencyPreference;
    }
}
