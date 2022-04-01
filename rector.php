<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    // paths to refactor; solid alternative to CLI arguments
    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);

    // here we can define, what sets of rules will be applied
    // tip: use "SetList" class to autocomplete sets
    $containerConfigurator->import(\Rector\Symfony\Set\SymfonyLevelSetList::UP_TO_SYMFONY_60);

    // register single rule
    $services = $containerConfigurator->services();
    $services->set(TypedPropertyRector::class);
};
