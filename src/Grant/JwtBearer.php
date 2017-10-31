<?php

namespace Jeylabs\OAuth2\Client\Grant;

class JwtBearer extends \League\OAuth2\Client\Grant\AbstractGrant
{
    protected function getName()
    {
        return 'urn:ietf:params:oauth:grant-type:jwt-bearer';
    }

    protected function getRequiredRequestParameters()
    {
        return [
            'assertion',
            'client_assertion',
            'redirect_uri',
        ];
    }
}