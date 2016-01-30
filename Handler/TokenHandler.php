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

        $token = $this->client->request('acquire_token', $args);
        if($token) {
            $this->saveToken($token); //todo string token
        }

        return $token;//todo wyciagnac string token
    }

    public function isTokenValid($token)
    {
        $args = [ $token ];
        $isValid = $this->request('is_token_valid', $args); //todo boola zwracac
        return true;
    }

    private function saveToken($token)
    {
        $this->yamlFileManager->write(['parameters' => ['wubook_token' => $token]]);
        $this->yamlFileManager->clearCache();
    }
}