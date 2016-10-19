<?php

namespace HelpMeAbstract\Entity\Notification;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Preference
{
    const CHANNEL_EMAIL = 'email';

    const FREQUENCY_DAILY = 'daily';
    const FREQUENCY_WEEKLY = 'weekly';
    const FREQUENCY_ON_DEMAND = 'on_demand';

    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $frequency;

    public function __construct(string $channel = self::CHANNEL_EMAIL, string $frequency = self::FREQUENCY_ON_DEMAND)
    {
        Assertion::inArray($channel, self::getAvailableChannels());
        Assertion::inArray($frequency, self::getAvailableFrequencies());

        $this->channel = $channel;
        $this->frequency = $frequency;
    }

    public static function getAvailableFrequencies() : array
    {
        return [
            self::FREQUENCY_ON_DEMAND,
            self::FREQUENCY_DAILY,
            self::FREQUENCY_WEEKLY,
        ];
    }

    public function getAvailableChannels()
    {
        return [
            self::CHANNEL_EMAIL,
        ];
    }

    /**
     * @return string
     */
    public function getChannel() : string
    {
        return $this->channel;
    }

    /**
     * @return string
     */
    public function getFrequency() : string
    {
        return $this->frequency;
    }
}
