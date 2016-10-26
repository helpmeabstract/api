<?php

namespace HelpMeAbstract\Entity\Notification;

interface Subject
{
    public function getUrl() : string;

    public function getExcerpt()  : string;

    public function getHeadline()  : string;
}
