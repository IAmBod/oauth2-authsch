<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Provider;

class BMEUnitScope
{
    public const TYPE_BME = 'BME';
    public const TYPE_BME_ACTIVE = 'BME_ACTIVE';
    public const TYPE_BME_VIK = 'BME_VIK';
    public const TYPE_BME_VIK_ACTIVE = 'BME_VIK_ACTIVE';
    public const TYPE_BME_VIK_NEWBIE = 'BME_VIK_NEWBIE';
    public const TYPE_BME_VBK = 'BME_VBK';
    public const TYPE_BME_VBK_ACTIVE = 'BME_VBK_ACTIVE';
    public const TYPE_BME_VBK_NEWBIE = 'BME_VBK_NEWBIE';

    /** @var string */
    private $type;

    public function __construct(
        string $type
    ) {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}