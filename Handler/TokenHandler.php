<?php

namespace Kamilwozny\WubookAPIBundle\Handler;

use Kamilwozny\WubookAPIBundle\Utils\YamlFileManager;

class TokenHandler extends BaseHandler
{
    /**
     * @var YamlFileManager
     */
    private $yamlFileManager;

    public function __construct(YamlFileManager $yamlFileManager)
    {
        $this->yamlFileManager = $yamlFileManager;
    }

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
            $this->saveToken($token);
            $this->client->setToken($token);
        }

        return $token; //todo handle token not found case
    }

    public function isCurrentTokenValid()
    {
        $isValid = $this->request('is_token_valid'); //todo boola zwracac
        return true;
    }

    public function releaseCurrentToken()
    {
        $response = $this->client->request('release_token', [], true, false);

        $isTokenReleased = $response->value()->me['array'][0]->scalarval() == 0;
        if($isTokenReleased) {
            $this->yamlFileManager->releaseToken();
        }

        return $isTokenReleased;
    }

    private function saveToken($token)
    {
        $this->yamlFileManager->write(['wubook_token' => $token]);
    }
}