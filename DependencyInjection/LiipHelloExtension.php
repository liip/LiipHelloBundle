<?php

namespace Liip\HelloBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class LiipHelloExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Loads the services based on your application configuration.
     *
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = $this->getFileLoader($container);
        $loader->load('config.yml');
    }

    public function prepend(ContainerBuilder $container)
    {
        // just an example of how to prepend the config of an extension
        // obviously it makes little sense to prepend a config to the same extension
        // but the idea is that the same approach would work with any other extension that is loaded
        $container->prependExtensionConfig($this->getAlias(), array('foo' => true));
    }

    /**
     * Get File Loader
     *
     * @param ContainerBuilder $container
     */
    public function getFileLoader($container)
    {
        return new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    }
}
