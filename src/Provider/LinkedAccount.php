<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Provider;

class LinkedAccount
{
    public const TYPE_BME = 'bme';
    public const TYPE_SCHACC = 'schacc';
    public const TYPE_VIR = 'vir';
    public const TYPE_VIRUID = 'virUid';

    /** @var string */
    private $id;

    /** @var string */
    private $type;

    public function __construct(
        string $id,
        string $type
    ) {
        $this->id = $id;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }
}