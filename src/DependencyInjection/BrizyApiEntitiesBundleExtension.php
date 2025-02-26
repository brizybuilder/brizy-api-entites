<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class BrizyApiEntitiesBundleExtension extends Extension
{
    public const ALIAS_NAME = 'brizy_api_entities';

    public const DOCTRINE_MAPPING = 'brizy_api_entities.persistence.doctrine.mapping';

    public const DOCTRINE_MANAGER = 'brizy_api_entities.persistence.doctrine.entity_manager';

    public function getAlias(): string
    {
        return 'brizy_api_entities';
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        if (isset($config['persistence']['doctrine']['entity_manager']['name'])) {
            $container->setParameter(self::DOCTRINE_MANAGER, $config['persistence']['doctrine']['entity_manager']['name']);
        }
    }

}
