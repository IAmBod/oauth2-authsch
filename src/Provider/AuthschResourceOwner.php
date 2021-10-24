<?php

declare(strict_types=1);

namespace IAmBod\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AuthschResourceOwner implements ResourceOwnerInterface
{
    /** @var array */
    private $data;

    /** @var AccessTokenInterface */
    private $token;

    public function __construct(array $resposne, AccessTokenInterface $accessToken)
    {
        $this->data = $resposne;
        $this->token = $accessToken;
    }

    public function getId(): string
    {
        return $this->get('internal_id');
    }

    public function getDisplayName(): string
    {
        return $this->get('displayName');
    }

    public function getLastName(): string
    {
        return $this->get('sn');
    }

    public function getFirstName(): string
    {
        return $this->get('givenName');
    }

    public function getEmail(): string
    {
        return $this->get('mail');
    }

    public function getNeptun(): ?string
    {
        return $this->get('niifPersonOrgID');
    }

    /**
     * @return array<LinkedAccount>
     */
    public function getLinkedAccounts(): array
    {
        $linkedAccounts = $this->get('linkedAccounts', []);

        return array_map(static function (string $type, string $id) {
            return new LinkedAccount($id, (string) $type);
        }, array_keys($linkedAccounts), array_values($linkedAccounts));
    }

    public function getSchAccount(): ?string
    {
        $linkedAccount = $this->getLinkedAccount(LinkedAccount::TYPE_SCHACC);

        return $linkedAccount !== null ? $linkedAccount->getId() : null;
    }

    public function getLinkedAccount(string $type): ?LinkedAccount
    {
        $linkedAccounts = $this->getLinkedAccounts();

        foreach ($linkedAccounts as $linkedAccount) {
            if ($linkedAccount->getType() === $type) {
                return $linkedAccount;
            }
        }

        return null;
    }

    /**
     * @return array<Synchronisation>
     * @throws \Exception
     */
    public function getLastSynchronisations(): array
    {
        $lastSynchronisations = $this->get('lastSync');

        return array_map(static function (string $type, ?int $timestamp) {
            $date = null;

            if (!empty($timestamp)) {
                $date = new \DateTime();
                $date->setTimestamp($timestamp);
            }

            return new Synchronisation(
                $type,
                $date
            );
        }, array_keys($lastSynchronisations), array_values($lastSynchronisations));
    }

    /**
     * @return array<Entitlement>
     * @throws \Exception
     */
    public function getEntitlements(): array
    {
        $entitlements = $this->get('eduPersonEntitlement', []);

        return array_map(function (array $entitlement) {
            $start = $this->getFrom($entitlement, 'start');

            if ($start !== null) {
                $start = new \DateTime($start);
            }

            $end = $this->getFrom($entitlement, 'end');

            if ($end !== null) {
                $end = new \DateTime($end);
            }

            return new Entitlement(
                $this->getFrom($entitlement, 'id'),
                $this->getFrom($entitlement, 'name'),
                $this->getFrom($entitlement, 'status'),
                $this->getFrom($entitlement, 'title', []),
                $start,
                $end
            );
        }, $entitlements);
    }

    public function getRoomNumber(): ?string
    {
        return $this->data['roomNumber'] ?? null;
    }

    public function getMobile(): ?string
    {
        return $this->data['mobile'] ?? null;
    }

    public function getCourses(): array
    {
        $courses = $this->get('niifEduPersonAttendedCourse');

        if (!empty($courses)) {
            $courses = explode(';', $courses);
        }

        return array_map(static function (array $code) {
            return new Course($code);
        }, $courses);
    }

    public function getEntrants(): array
    {
        $entrants = $this->get('entrants', []);

        return array_map(function (array $entrant) {
            return new Entrant(
                $this->getFrom($entrant, 'groupId'),
                $this->getFrom($entrant, 'groupName'),
                $this->getFrom($entrant, 'entrantType')
            );
        }, $entrants);
    }

    public function getActiveDirectoryMemberships(): array
    {
        return $this->get('admembership', []);
    }

    /**
     * @return array<BMEUnitScope>
     */
    public function getBmeUnitScopes(): array
    {
        $bmeUnitScopes = $this->get('bmeunitscope', []);

        return array_map(static function (array $bmeUnitScope) {
            return new BMEUnitScope($bmeUnitScope);
        }, $bmeUnitScopes);
    }

    /**
     * @return \DateTime|null
     * @throws \Exception
     */
    public function getBirthDate(): ?\DateTime
    {
        $birthDate = $this->get('birthdate');

        return !empty($birthDate) ? new \DateTime($birthDate) : null;
    }

    public function getPermanentAddress(): ?string
    {
        return $this->get('permanentaddress');
    }

    public function getToken(): AccessTokenInterface
    {
        return $this->token;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    private function get(string $key, $default = null)
    {
        return $this->getFrom($this->data, $key, $default);
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    private function getFrom(array $data, string $key, $default = null)
    {
        return $data[$key] ?? $default;
    }
}