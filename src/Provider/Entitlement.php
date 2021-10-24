<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Provider;

class Entitlement
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $status;

    /** @var array<string> */
    private $titles;

    /** @var \DateTime|null */
    private $start;

    /** @var \DateTime|null */
    private $end;

    public function __construct(
        int $id,
        string $name,
        string $status,
        array $titles,
        ?\DateTime $start,
        ?\DateTime $end
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->titles = $titles;
        $this->start = $start;
        $this->end = $end;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array<string>
     */
    public function getTitles(): array
    {
        return $this->titles;
    }

    public function getStart(): ?\DateTime
    {
        return $this->start;
    }

    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }
}