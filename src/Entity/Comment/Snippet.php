<?php

namespace HelpMeAbstract\Entity\Comment;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Snippet
{
    /**
     * @ORM\Column(
     *      type="string",
     *      nullable = true
     * )
     *
     * @var string
     */
    private $body;

    /**
     * @ORM\Column(
     *      type="integer",
     *      name="start_index",
     *      nullable = true
     * )
     *
     * @var int
     */
    private $startIndex;

    /**
     * @ORM\Column(
     *      type="integer",
     *      name="stop_index",
     *      nullable = true
     * )
     *
     * @var int
     */
    private $stopIndex;

    public function __construct(string $body, int $startIndex, int $stopIndex)
    {
        $this->body = $body;
        $this->startIndex = $startIndex;
        $this->stopIndex = $stopIndex;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getStartIndex()
    {
        return $this->startIndex;
    }

    /**
     * @return int
     */
    public function getStopIndex()
    {
        return $this->stopIndex;
    }
}
