<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Provider;

class Course
{
    /** @var string */
    private $code;

    public function __construct(
        string $code
    ) {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}