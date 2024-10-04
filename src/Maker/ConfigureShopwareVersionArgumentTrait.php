<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Maker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Finder\Finder;

trait ConfigureShopwareVersionArgumentTrait
{
    private function configureShopwareVersionArgument(string $projectDirectory, Finder $finder, Command $command): void
    {
        $entitySchemaFileFinder = $finder
            ->in($projectDirectory . '/data')
            ->exclude('redundant')
            ->name('/entity-schema_[0-9]{1,}\.[0-9]{1,}\.[0-9]{1,}\.[0-9]{1,}\.json/')
            ->sortByName(true);

        $shopwareVersions = [];
        foreach ($entitySchemaFileFinder as $file) {
            $shopwareVersions[] = str_replace('entity-schema_', '', $file->getBasename('.json'));
        }
        $shopwareVersionsWithQuotes = array_map(fn (string $version) => "\"$version\"", $shopwareVersions);

        $command->addArgument(
            'shopware-version',
            InputArgument::REQUIRED,
            sprintf('Choose the Shopware version for which the classes should be generated. Available options are %s.', implode(', ', $shopwareVersionsWithQuotes)),
            suggestedValues: $shopwareVersions
        );
    }
}
