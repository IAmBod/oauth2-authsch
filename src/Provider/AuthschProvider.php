<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Provider;

use IAmBod\OAuth2\Client\Exception\AuthschIdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class AuthschProvider extends AbstractProvider
{
    protected $scopes;

    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);

        $this->scopes = $options['scopes'] ?? [];
    }

    public function getBaseAuthorizationUrl(): string
    {
        return 'https://auth.sch.bme.hu/site/login';
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://auth.sch.bme.hu/oauth2/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return 'https://auth.sch.bme.hu/api/profile?access_token=' . $token->getToken();
    }

    protected function getDefaultScopes(): array
    {
        return $this->scopes;
    }

    protected function getScopeSeparator(): string
    {
        return ' ';
    }

    /**
     * @param ResponseInterface $response
     * @param array|string $data
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if ($response->getStatusCode() >= 400) {
            throw AuthschIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw AuthschIdentityProviderException::oauthException($response, $data);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): AuthschResourceOwner
    {
        return new AuthschResourceOwner($response, $token);
    }
}