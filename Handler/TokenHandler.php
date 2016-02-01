<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Utils\RpcValueDecoder;

class TokenHandler extends BaseHandler
{
    public function acquireToken()
    {
        $args = [
            strval($this->client->credentials['username']),
            strval($this->client->credentials['password']),
            strval($this->client->credentials['provider_key'])
        ];

        $response = $this->client->request('acquire_token', $args, false, false, false);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        $tokenAcquired = $parsedResponse[0] == 0;
        if($tokenAcquired) {
            $token = $response->value()->me['array'][1]->scalarval();
            $this->client->tokenProvider->setToken($token);

            return $token;
        }

        return null; //todo handle token not found case
    }

    public function isCurrentTokenValid($returnWholeResponse = false)
    {
        $response = $this->client->request('is_token_valid', [], true, false, false);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        $isTokenValid = $parsedResponse[0] == 0;

        return $returnWholeResponse ? $parsedResponse : $isTokenValid;
    }

    public function releaseCurrentToken()
    {
        $response = $this->client->request('release_token', [], true, false, false);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        $isTokenReleased = $parsedResponse[0] == 0;
        if($isTokenReleased) {
            $this->client->tokenProvider->removeCurrentSavedToken();
        }

        return $isTokenReleased;
    }

    public function providerInfo()
    {
        $response = $this->client->request('provider_info', [], true, false, false);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        return $parsedResponse[1];
    }


}