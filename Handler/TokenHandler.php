<?php

namespace Kamilwozny\WubookAPIBundle\Handler;

class TokenHandler extends BaseHandler
{
    public function acquireToken()
    {
        $args = [
            $this->client->credentials['username'],
            $this->client->credentials['password'],
            $this->client->credentials['provider_key']
        ];

        $response = $this->client->request('acquire_token', $args, false, false);

        $token = '';
        if(!$response->errno) {
            $token = $response->value()->me['array'][1]->scalarval();
            $this->client->tokenProvider->setToken($token);
        }

        return $token; //todo handle token not found case
    }

    public function isCurrentTokenValid()
    {
        $response = $this->client->request('is_token_valid', [], true, false, false);
        $isTokenValid = $response->value()->me['array'][0]->scalarval() == 0;

        return $isTokenValid;
    }

    public function releaseCurrentToken()
    {
        $response = $this->client->request('release_token', [], true, false, false);

        $isTokenReleased = $response->value()->me['array'][0]->scalarval() == 0;
        if($isTokenReleased) {
            $this->client->tokenProvider->removeCurrentSavedToken();
        }

        return $isTokenReleased;
    }
}