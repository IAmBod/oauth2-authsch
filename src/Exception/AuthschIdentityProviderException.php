<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Exception;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;

class AuthschIdentityProviderException extends IdentityProviderException
{
    /**
     * @param ResponseInterface $response
     * @param array|string $data
     * @return IdentityProviderException
     */
    public static function clientException(ResponseInterface $response, $data): IdentityProviderException
    {
        return static::fromResponse(
            $response,
            self::parseError($response, $data)
        );
    }

    /**
     * @param ResponseInterface $response
     * @param array|string $data
     * @return IdentityProviderException
     */
    public static function oauthException(ResponseInterface $response, $data): IdentityProviderException
    {
        return static::fromResponse(
            $response,
            self::parseError($response, $data)
        );
    }

    /**
     * @param ResponseInterface $response
     * @param string|null $message
     * @return IdentityProviderException
     */
    protected static function fromResponse(ResponseInterface $response, ?string $message = null): IdentityProviderException
    {
        return new static($message, $response->getStatusCode(), (string) $response->getBody());
    }

    /**
     * @param ResponseInterface $response
     * @param array|string $data
     * @return string|null
     */
    private static function parseError(ResponseInterface $response, $data): ?string
    {
        if (empty($data)) {
            return $response->getReasonPhrase();
        }

        if (is_string($data)) {
            return $data;
        }

        if (is_array($data) && isset($data['error']) && !empty($data['error'])) {
            return $data['error'];
        }

        return $response->getReasonPhrase();
    }
}