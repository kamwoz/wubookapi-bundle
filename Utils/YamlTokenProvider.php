<?php

namespace Kamilwozny\WubookAPIBundle\Utils;

use LogicException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

/**
 * Class provides fresh token information
 */
class YamlTokenProvider implements TokenProviderInterface
{
    /**
     * @var string
     */
    private $tokenFilePath;

    public function __construct($tokenFilePath)
    {
        $this->tokenFilePath = $tokenFilePath;
    }

    public function getToken()
    {
        $yaml = new Parser();

        try {
            if(file_exists($this->tokenFilePath) && is_readable($this->tokenFilePath)){
                $data = $yaml->parse(file_get_contents($this->tokenFilePath));

                return $data['wubook_token'];
            }
        } catch (ParseException $e) {
            printf("Couldn't parse to YAML: %s", $e->getMessage());
        }

        return null;
    }

    public function setToken($token)
    {
        if (!$this->tokenFilePath) {
            throw new LogicException('There is no write path, try to load() file first');
        }

        if (file_exists($this->tokenFilePath) && !is_writable($this->tokenFilePath)) {
            throw new AccessDeniedException(sprintf('path %s is not writable', $this->tokenFilePath));
        }

        $dumper = new Dumper();
        $yaml = $dumper->dump(['wubook_token' => $token], 3);

        file_put_contents($this->tokenFilePath, $yaml);
    }

    public function removeCurrentSavedToken()
    {
        $fs = new Filesystem();
        $fs->remove($this->tokenFilePath);
    }
}