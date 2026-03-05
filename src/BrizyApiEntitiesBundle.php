<?php

namespace Brizy\Bundle\ApiEntitiesBundle;

use Brizy\Bundle\ApiEntitiesBundle\DependencyInjection\BrizyApiEntitiesBundleExtension;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BrizyApiEntitiesBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new BrizyApiEntitiesBundleExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->configureDoctrineExtension($container);
    }

    private function configureDoctrineExtension(ContainerBuilder $container): void
    {
        $namespaces = ['Brizy\Bundle\ApiEntitiesBundle\Entity'];
        $directories = [realpath(__DIR__.'/Entity')];
        $managerParameters = [BrizyApiEntitiesBundleExtension::DOCTRINE_MANAGER];
        $aliasMap = ['BrizyApiEntitiesBundle' => 'Brizy\Bundle\ApiEntitiesBundle\Entity'];

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createAnnotationMappingDriver(
                $namespaces,
                $directories,
                $managerParameters,
                false,
                $aliasMap
            ),
            \Symfony\Component\DependencyInjection\Compiler\PassConfig::TYPE_BEFORE_OPTIMIZATION,
            0
        );
    }
}
