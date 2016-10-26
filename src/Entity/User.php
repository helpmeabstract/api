<?php

namespace HelpMeAbstract\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Behavior\HasUuid;
use HelpMeAbstract\Entity\Notification\Preference;

/**
 * @ORM\Entity(repositoryClass="HelpMeAbstract\Repository\UserRepository")
 * @ORM\Table( name="users")
 */
class User
{
    const TYPE_USER = 'user';
    const TYPE_ADMIN = 'admin';
    const TYPE_VOLUNTEER = 'volunteer';

    use HasUuid;

    /**
     * @ORM\Column(
     *      type="string",
     *     name ="first_name"
     * )
     *
     * @var string
     */
    private $firstName;

    /**
     * @ORM\Column(
     *      type="string",
     *     name ="last_name"
     * )
     *
     * @var string
     */
    private $lastName;

    /**
     * @ORM\Column(
     *      type="string"
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(
     *      type="string",
     *     name ="twitter_handle"
     * )
     *
     * @var string
     */
    private $twitterHandle;

    /**
     * @ORM\Column(
     *      type="string",
     *     name="github_handle"
     * )
     *
     * @var string
     */
    private $githubHandle;

    /**
     * @ORM\Column(
     *      type="string"
     * )
     *
     * @var string
     */
    private $type;

    /**
     * @ORM\Embedded(class = "HelpMeAbstract\Entity\Notification\Preference")
     */
    private $notificationPreference;

    /**
     * @ORM\Column(
     *      type="boolean",
     *     name="show_profile"
     * )
     *
     * @var bool
     */
    private $showProfile;

    /**
     * @ORM\Column(
     *      type="string",
     *      name="age_range",
     *      nullable=true
     * )
     *
     * @var string
     */
    private $ageRange;

    /**
     * @ORM\Column(
     *      type="string",
     *      nullable=true
     * )
     *
     * @var string
     */
    private $gender;

    /**
     * @ORM\Column(
     *      type="string",
     *      name="primary_spoken_language",
     *      nullable=true
     * )
     *
     * @var string
     */
    private $primarySpokenLanguage;

    /**
     * @ORM\Column(
     *      type="string",
     *      nullable=true
     * )
     *
     * @var string
     */
    private $location;

    /**
     * @ORM\Column(
     *      type="string",
     *      name="primary_technical_language",
     *      nullable=true
     * )
     *
     * @var string
     */
    private $primaryTechnicalLanguage;

    /**
     * @ORM\Column(
     *      type="string",
     *      name="time_previously_spoken",
     *      nullable=true
     * )
     *
     * @var string
     */
    private $timesPreviouslySpoken;

    /**
     * @ORM\Column(
     *      type="string",
     *      name="auth_token"
     * )
     *
     * @var string
     */
    private $authToken;

    /**
     * @ORM\Column(
     *      type="string",
     *      name="auth_source"
     * )
     *
     * @var string
     */
    private $authSource;

    /**
     * @ORM\OneToMany(targetEntity="HelpMeAbstract\Entity\Comment", mappedBy="author")
     *
     * @var Comment[]|ArrayCollection
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="HelpMeAbstract\Entity\Notification", mappedBy="recipient")
     *
     * @var Notification[]|ArrayCollection
     */
    private $notifications;

    /**
     * @var Submission[]|ArrayCollection
     */
    private $submissions;

    private function __construct($type = null)
    {
        $this->type = $type ?: self::TYPE_USER;
        $this->comments = new ArrayCollection();
        $this->submissions = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getReviews() : ArrayCollection
    {
        return $this->comments->filter(function (Comment $comment) {
            return $comment->getRevision()->getUser()->getId() !== $this->getId();
        });
    }

    /**
     * @return bool
     */
    public function isVolunteer() : bool
    {
        return $this->type == self::TYPE_VOLUNTEER;
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool
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
     * @param Preference $notificationPreference
     */
    public function setNotificationPreference(Preference $notificationPreference)
    {
        $this->notificationPreference = $notificationPreference;
    }

    /**
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName() : string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTwitterHandle() : string
    {
        return $this->twitterHandle;
    }

    /**
     * @param string $twitterHandle
     */
    public function setTwitterHandle(string $twitterHandle)
    {
        $this->twitterHandle = $twitterHandle;
    }

    /**
     * @return string
     */
    public function getGithubHandle() : string
    {
        return $this->githubHandle;
    }

    /**
     * @param string $githubHandle
     */
    public function setGithubHandle(string $githubHandle)
    {
        $this->githubHandle = $githubHandle;
    }

    /**
     * @return bool
     */
    public function getShowProfile() : bool
    {
        return $this->showProfile;
    }

    /**
     * @param bool $showProfile
     */
    public function setShowProfile(bool $showProfile)
    {
        $this->showProfile = $showProfile;
    }

    /**
     * @return Notification[]|ArrayCollection
     */
    public function getNotifications() : ArrayCollection
    {
        return $this->notifications;
    }

    /**
     * @return string
     */
    public function getTimesPreviouslySpoken() : string
    {
        return $this->timesPreviouslySpoken;
    }

    /**
     * @param string $timesPreviouslySpoken
     */
    public function setTimesPreviouslySpoken(string $timesPreviouslySpoken)
    {
        $this->timesPreviouslySpoken = $timesPreviouslySpoken;
    }

    /**
     * @return string
     */
    public function getPrimaryTechnicalLanguage() : string
    {
        return $this->primaryTechnicalLanguage;
    }

    /**
     * @param string $primaryTechnicalLanguage
     */
    public function setPrimaryTechnicalLanguage(string $primaryTechnicalLanguage)
    {
        $this->primaryTechnicalLanguage = $primaryTechnicalLanguage;
    }

    /**
     * @return string
     */
    public function getLocation() : string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getPrimarySpokenLanguage() : string
    {
        return $this->primarySpokenLanguage;
    }

    /**
     * @param string $primarySpokenLanguage
     */
    public function setPrimarySpokenLanguage(string $primarySpokenLanguage)
    {
        $this->primarySpokenLanguage = $primarySpokenLanguage;
    }

    /**
     * @return string
     */
    public function getGender() : string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getAgeRange() : string
    {
        return $this->ageRange;
    }

    /**
     * @param string $ageRange
     */
    public function setAgeRange(string $ageRange)
    {
        $this->ageRange = $ageRange;
    }

    /**
     * @return Preference
     */
    public function getNotificationPreference() : Preference
    {
        return $this->notificationPreference;
    }

    /**
     * @return string
     */
    public function getAuthToken() : string
    {
        return $this->authToken;
    }

    /**
     * @param string $authToken
     */
    public function setAuthToken(string $authToken)
    {
        $this->authToken = $authToken;
    }

    /**
     * @return string
     */
    public function getAuthSource() : string
    {
        return $this->authSource;
    }

    /**
     * @param string $authSource
     */
    public function setAuthSource(string $authSource)
    {
        $this->authSource = $authSource;
    }
}
