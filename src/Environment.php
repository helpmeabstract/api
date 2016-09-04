<?php

namespace HelpMeAbstract;

use Assert\Assertion;

class Environment
{
    const TESTING = 'testing';
    const DEVELOPMENT = 'development';
    const PRODUCTION = 'production';

    /**
     * @var string $type
     */
    private $type;

    public function __construct($environment)
    {
        Assertion::inArray($environment, [
            self::PRODUCTION,
            self::TESTING,
            self::DEVELOPMENT,
        ]);

        $this->type = $environment;
    }

    public function isTesting()
    {
        return $this->type === self::TESTING;
    }

    public function isProduction()
    {
        return $this->type === self::PRODUCTION;
    }

    public function isDevelopment()
    {
        return $this->type === self::DEVELOPMENT;
    }
}