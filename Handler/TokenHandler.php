<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\Exception\WubookException;
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
            $token = $parsedResponse[1];
            $this->client->tokenProvider->setToken($token);

            return $token;
        }

        throw new WubookException('Cant acquire new token, returned message:"' . $parsedResponse[1] .'"');
    }

    public function isCurrentTokenValid()
    {
        $response = $this->client->request('is_token_valid', [], true, false, false);
        $parsedResponse = RpcValueDecoder::parseRpcValue($response->value());

        $isTokenValid = $parsedResponse[0] == 0;

        return $isTokenValid;
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