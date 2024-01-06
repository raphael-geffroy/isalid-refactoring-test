<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Kernel
{
    private ?ContainerInterface $container = null;

    public function boot(): void
    {
        $this->container = new ContainerBuilder();

        $yamlFileLoader = new YamlFileLoader($this->container, new FileLocator(dirname(__FILE__, 2).'/config'));
        $yamlFileLoader->load('services.yaml');

        $this->container->compile();
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container
            ?? throw new \RuntimeException("Kernel is not booted.");
    }


}
