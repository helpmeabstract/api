<?php

namespace HelpMeAbstract\Controller;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Comment implements LoggerAwareInterface
{
    use LoggerAwareTrait;
}
