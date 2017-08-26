<?php

namespace HelpMeAbstract\Transformer;

use HelpMeAbstract\Entity\Notification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'subject',
        'recipient',
    ];

    /**
     * @var UserTransformer
     */
    private $recipientTransformer;

    /**
     * @var NotificationSubjectTransformer
     */
    private $subjectTransformer;

    public function __construct(
        UserTransformer $recipientTransformer = null,
        NotificationSubjectTransformer $subjectTransformer = null)
    {
        $this->recipientTransformer = $recipientTransformer ?: new UserTransformer();
        $this->subjectTransformer = $subjectTransformer ?: new NotificationSubjectTransformer();
    }

    /**
     * @param Notification $notification
     *
     * @return array
     */
    public function transform(Notification $notification) : array
    {
        return [
            'id' => $notification->getId(),
            'created_date' => $notification->getCreateDate()->format(DATE_ATOM),
            'date_sent' => $notification->getDateSent()->format(DATE_ATOM),
            'date_read' => $notification->getDateRead()->format(DATE_ATOM),
            'status' => $notification->getStatus(),
        ];
    }

    /**
     * @param Notification|null $notification
     *
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\NullResource
     */
    public function includeSubject(Notification $notification = null)
    {
        if ($notification === null) {
            return $this->null();
        }

        return $this->item($notification->getSubject(), $this->subjectTransformer);
    }

    /**
     * @param Notification|null $notification
     *
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\NullResource
     */
    public function includeRecipient(Notification $notification = null)
    {
        if ($notification === null) {
            return $this->null();
        }

        return $this->item($notification->getRecipient(), $this->recipientTransformer);
    }
}
