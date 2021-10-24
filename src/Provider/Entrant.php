<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Provider;

class Entrant
{
    public const TYPE_AB = 'AB';
    public const TYPE_KB = 'KB';

    /** @var int */
    private $groupId;

    /** @var string */
    private $groupName;

    /** @var string */
    private $type;

    public function __construct(
        int $groupId,
        string $groupName,
        string $type
    ) {
        $this->groupId = $groupId;
        $this->groupName = $groupName;
        $this->type = $type;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function getType(): string
    {
        return $this->type;
    }
}