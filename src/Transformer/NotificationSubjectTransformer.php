<?php

namespace HelpMeAbstract\Transformer;

use HelpMeAbstract\Entity\Notification\Subject;
use League\Fractal\TransformerAbstract;

class NotificationSubjectTransformer extends TransformerAbstract
{
    public function transform(Subject $subject = null) :array
    {
        if ($subject === null) {
            return $this->null();
        }

        return [
            'url' => $subject->getUrl(),
            'excerpt' => $subject->getExcerpt(),
            'headline' => $subject->getHeadline(),
        ];
    }
}
