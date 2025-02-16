<?php

namespace Jeylabs\OAuth2\Client\Token;

use DomainException;
use InvalidArgumentException;
use RuntimeException;
use League\OAuth2\Client\Tool\RequestFactory;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AccessToken extends \League\OAuth2\Client\Token\AccessToken
{
    protected $idToken;
    protected $idTokenClaims;

    public function __construct(array $options = [], $provider)
    {
        parent::__construct($options);
        if (!empty($options['id_token'])) {
            $this->idToken = $options['id_token'];

            $keys = $provider->getJwtVerificationKeys();
            $idTokenClaims = null;
            try {
                $tks = explode('.', $this->idToken);
                // Check if the id_token contains signature
                if (count($tks) == 3 && !empty($tks[2])) {
                    $idTokenClaims = (array)JWT::decode($this->idToken, new Key($keys, 'RS256'));
                } else {
                    // The id_token is unsigned (coming from v1.0 endpoint) - https://msdn.microsoft.com/en-us/library/azure/dn645542.aspx

                    // Since idToken is not signed, we just do OAuth2 flow without validating the id_token
                    // // Validate the access_token signature first by parsing it as JWT into claims
                    // $accessTokenClaims = (array)JWT::decode($options['access_token'], $keys, ['RS256']);
                    // Then parse the idToken claims only without validating the signature
                    $idTokenClaims = (array)JWT::jsonDecode(JWT::urlsafeB64Decode($tks[1]));
                }
            } catch (DomainException $e) {
                throw new RuntimeException("Unable to parse the id_token!");
            }
            if ($provider->getClientId() != $idTokenClaims['aud']) {
                throw new RuntimeException("The audience is invalid!");
            }
            if ($idTokenClaims['nbf'] > time() || $idTokenClaims['exp'] < time()) {
                // Additional validation is being performed in firebase/JWT itself
                throw new RuntimeException("The id_token is invalid!");
            }

            if ($provider->tenant == "common") {
                $provider->tenant = $idTokenClaims['tid'];

                $tenant = $provider->getTenantDetails($provider->tenant);
                if ($idTokenClaims['iss'] != $tenant['issuer']) {
                    throw new RuntimeException("Invalid token issuer!");
                }
            } else {
                $tenant = $provider->getTenantDetails($provider->tenant);
                if ($idTokenClaims['iss'] != $tenant['issuer']) {
                    throw new RuntimeException("Invalid token issuer!");
                }
            }

            $this->idTokenClaims = $idTokenClaims;
        }
    }

    public function getIdTokenClaims()
    {
        return $this->idTokenClaims;
    }
}
