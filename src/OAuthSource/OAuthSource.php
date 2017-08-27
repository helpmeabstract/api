<?php

namespace HelpMeAbstract\OAuthSource;

interface OAuthSource
{
    public function getUser($code): array;
}
