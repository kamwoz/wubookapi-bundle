<?php

namespace Kamilwozny\WubookAPIBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class WubookAPIExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor     = new Processor();
        $configuration = new Configuration();
        $config        = $processor->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        $container->setParameter('wubook_api.client_username', $config['client_username']);
        $container->setParameter('wubook_api.client_password', $config['client_password']);
        $container->setParameter('wubook_api.provider_key', $config['provider_key']);
        $container->setParameter('wubook_api.property_id', $config['property_id']);
        $container->setParameter('wubook_api.url', $config['url']);
        $container->setParameter('wubook_api.token', $config['token']);
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration();
    }
}