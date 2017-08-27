<?php

namespace HelpMeAbstract\Event;

use HelpMeAbstract\Entity\Revision;
use HelpMeAbstract\Entity\User;
use League\Event\AbstractEvent;
use League\Event\EventInterface;

class Proposal extends AbstractEvent implements EventInterface
{
    public const CREATED = 'created';
    public const UPDATED = 'updated';
    public const DELETED = 'deleted';

    /** @var Revision */
    private $proposal;

    /** @var User */
    private $author;

    /** @var string */
    private $event_type;

    /**
     * ProposalCreated constructor.
     * @param Revision $proposal
     * @param User $author
     * @param string $event_type
     */
    private function __construct(Revision $proposal, User $author, string $event_type)
    {
        $this->proposal = $proposal;
        $this->author = $author;
        $this->event_type = $event_type;
    }

    public static function created(Revision $proposal, User $author)
    {
        return new self($proposal, $author, static::CREATED);
    }

    public static function updated(Revision $proposal, User $author)
    {
        return new self($proposal, $author, static::UPDATED);
    }

    public static function deleted(Revision $proposal, User $author)
    {
        return new self($proposal, $author, static::DELETED);
    }

    /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->event_type;
    }

    /**
     * @return Revision
     */
    public function getProposal()
    {
        return $this->proposal;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}