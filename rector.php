<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonyLevelSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    // paths to refactor; solid alternative to CLI arguments
    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);

    // here we can define, what sets of rules will be applied
    // tip: use "SetList" class to autocomplete sets
//    $containerConfigurator->import(SymfonyLevelSetList::UP_TO_SYMFONY_60);
    $containerConfigurator->import(LevelSetList::UP_TO_PHP_81);
};
