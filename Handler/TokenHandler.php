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

    /**
     * Creates new token
     * @return mixed
     * @throws WubookException
     */
    public function acquireToken()
    {
        $args = [
            $this->username,
            $this->password,
            $this->provider_key
        ];

        $token = parent::defaultRequestHandler('acquire_token', $args, false, false, false);

        $this->client->tokenProvider->setToken($token);
        return $token;
    }

    /**
     * @return bool true if token is valid
     */
    public function isCurrentTokenValid()
    {
        $response = $this->client->request('is_token_valid', [], true, false, false);
        $parsedResponse = ResponseDecoder::decodeResponse($response);

        $isTokenValid = $parsedResponse[0] == 0;

        return $isTokenValid;
    }

    /**
     * @return bool true if token was sucessfully released
     */
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

    /**
     * Gets stats about current token
     * @return mixed
     * @throws WubookException
     */
    public function providerInfo()
    {
        return parent::defaultRequestHandler('provider_info', [], true, false, false);
    }
}