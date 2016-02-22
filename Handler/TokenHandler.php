<?php

namespace Kamwoz\WubookAPIBundle\Handler;

use Kamwoz\WubookAPIBundle\Exception\WubookException;
use Kamwoz\WubookAPIBundle\Utils\ResponseDecoder;

class TokenHandler extends BaseHandler
{
    private $username;

    private $password;

    private $provider_key;

    /**
     * TokenHandler constructor.
     *
     * @param $username
     * @param $password
     * @param $provider_key
     */
    public function __construct($username, $password, $provider_key)
    {
        $this->username = strval($username);
        $this->password = strval($password);
        $this->provider_key = strval($provider_key);
    }

    public function acquireToken()
    {
        $args = [
            $this->username,
            $this->password,
            $this->provider_key
        ];

        $response = $this->client->request('acquire_token', $args, false, false, false);
        $parsedResponse = ResponseDecoder::decodeResponse($response);

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
        $parsedResponse = ResponseDecoder::decodeResponse($response);

        $isTokenValid = $parsedResponse[0] == 0;

        return $isTokenValid;
    }

    public function releaseCurrentToken()
    {
        $response = $this->client->request('release_token', [], true, false, false);
        $parsedResponse = ResponseDecoder::decodeResponse($response);

        $isTokenReleased = $parsedResponse[0] == 0;
        if($isTokenReleased) {
            $this->client->tokenProvider->removeCurrentSavedToken();
        }

        return $isTokenReleased;
    }

    public function providerInfo()
    {
        $response = $this->client->request('provider_info', [], true, false, false);
        $parsedResponse = ResponseDecoder::decodeResponse($response);

        return $parsedResponse[1];
    }
}