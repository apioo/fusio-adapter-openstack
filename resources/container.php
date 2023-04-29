<?php

use Fusio\Adapter\OpenStack\Connection\BlockStorage;
use Fusio\Adapter\OpenStack\Connection\Compute;
use Fusio\Adapter\OpenStack\Connection\Identity;
use Fusio\Adapter\OpenStack\Connection\Images;
use Fusio\Adapter\OpenStack\Connection\Networking;
use Fusio\Adapter\OpenStack\Connection\ObjectStore;
use Fusio\Engine\Adapter\ServiceBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
    $services = ServiceBuilder::build($container);
    $services->set(BlockStorage::class);
    $services->set(Compute::class);
    $services->set(Identity::class);
    $services->set(Images::class);
    $services->set(Networking::class);
    $services->set(ObjectStore::class);
};
