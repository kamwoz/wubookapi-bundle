<?php

namespace Kamilwozny\WubookAPIBundle\Utils;

use LogicException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

/**
 * Usługa która otwiera plik konfigu np parameters.yml i daje możliwość //todo opis
 * manipulowania jego danymi (np możliwość zapisu nowych danych)
 * Class ConfigFileManager
 * @package AppBundle\Service
 */
class YamlFileManager {

    private $writePath;

    private $content;

    /**
     * Loads file
     * @param $filename
     */
    public function load($filename){
        $this->writePath = $filename;
        $yaml = new Parser();

        try {
            if(file_exists($filename) && is_readable($filename)){
                $this->content = $yaml->parse(file_get_contents($filename));
            }
        } catch (ParseException $e) {
            printf("Couldn't parse to YAML: %s", $e->getMessage());
        }
    }

    /**
     * saving file to place where it was loaded
     * @param $data
     */
    public function write($data){

        if (!$this->writePath) {
            throw new LogicException('There is no write path, try to load() file first');
        }

        if (file_exists($this->writePath) && !is_writable($this->writePath)) {
            throw new AccessDeniedException(sprintf('path %s is not writable', $this->writePath));
        }

        $dumper = new Dumper();
        $yaml = $dumper->dump($data, 3);

        file_put_contents($this->writePath, $yaml);
    }

    public function releaseToken()
    {
        $fs = new Filesystem();
        $fs->remove($this->writePath);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}