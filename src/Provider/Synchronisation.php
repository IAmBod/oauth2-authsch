<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Provider;

class Synchronisation
{
    /** @var string */
    public $type;

    /** @var \DateTime|null */
    public $date;

    public function __construct(
        string $type,
        ?\DateTime $date = null
    ) {
        $this->type = $type;
        $this->date = $date;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }
}