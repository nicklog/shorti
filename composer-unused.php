<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use Webmozart\Glob\Glob;

return static function (Configuration $config): Configuration {
    $configFilesFor = [
        'sensio/framework-extra-bundle',
        'doctrine/doctrine-migrations-bundle',
        'doctrine/doctrine-migrations-bundle',
        'knplabs/knp-paginator-bundle',
    ];
    $configDir      = Glob::glob(__DIR__ . '/config/*.php');

    $config
        ->addNamedFilter(NamedFilter::fromString('symfony/flex'))
        ->addNamedFilter(NamedFilter::fromString('symfony/monolog-bundle'))
        ->addNamedFilter(NamedFilter::fromString('symfony/security-bundle'))
        ->addNamedFilter(NamedFilter::fromString('symfony/webpack-encore-bundle'))
        ->addNamedFilter(NamedFilter::fromString('symfony/dotenv'))
        ->addNamedFilter(NamedFilter::fromString('symfony/lock'))
        ->addNamedFilter(NamedFilter::fromString('symfony/yaml'))
        ->addNamedFilter(NamedFilter::fromString('symfony/process'))
        ->addNamedFilter(NamedFilter::fromString('symfony/mime'))
        ->addNamedFilter(NamedFilter::fromString('symfony/runtime'))
        ->addNamedFilter(NamedFilter::fromString('symfony/apache-pack'))
        ->addNamedFilter(NamedFilter::fromString('symfony/http-client'))
        ->addNamedFilter(NamedFilter::fromString('doctrine/doctrine-migrations-bundle'))
        ->addNamedFilter(NamedFilter::fromString('knplabs/knp-paginator-bundle'))
        ->addNamedFilter(NamedFilter::fromString('twig/extra-bundle'))
        ->addNamedFilter(NamedFilter::fromString('twig/string-extra'))
        ->addNamedFilter(NamedFilter::fromString('sensio/framework-extra-bundle'))
        ->addNamedFilter(NamedFilter::fromString('beberlei/doctrineextensions'));

    foreach ($configFilesFor as $for) {
        $config->setAdditionalFilesFor($for, $configDir);
    }

    return $config;
};
