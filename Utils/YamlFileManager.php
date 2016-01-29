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

    private $kernelCacheDir;

    public function setKernelCacheDir($kernelCacheDir)
    {
        $this->kernelCacheDir = $kernelCacheDir;
    }

    /**
     * Loads file
     * @param $filename
     */
    public function load($filename){
        $this->writePath = $filename;
        $yaml = new Parser();

        try {
            if(is_readable($filename)){
                $this->content = $yaml->parse(file_get_contents($filename));
            } else {
                throw new \RuntimeException('Nie ma takiego pliku lub nie jest do odczytu');
            }
        } catch (ParseException $e) {
            printf("Nie udało się sparsować YAML'a: %s", $e->getMessage());
        }
    }

    /**
     * saving file to place where it was loaded
     * @param $formData
     */
    public function write($formData){

        if (!$this->writePath) {
            throw new LogicException('Nie mam gdzie zapisać konfigu');
        }

        if (!is_writable($this->writePath)) {
            throw new AccessDeniedException('Plik konfigu nie jest zapisywalny. Sprawdź uprawnienia (664 z grupą w której jest użytkownik wykonujący polecenia php na serwerze)');
        }

        $dumper = new Dumper();
        $this->merge($formData);
        $yaml = $dumper->dump($this->getContent(), 3);

        file_put_contents($this->writePath, $yaml);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Merge form data with current config data
     * @param $formData
     *
     * @return $this
     */
    private function merge( $formData )
    {
        $this->content = array_replace_recursive($this->content, array('parameters' => $formData));

        return $this;
    }

    /**
     * Removes whole cache directory, probably not best place for it
     */
    public function clearCache()
    {
        $fs = new Filesystem();
        $fs->remove($this->kernelCacheDir);
    }

}