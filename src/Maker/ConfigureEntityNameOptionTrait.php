<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Maker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

trait ConfigureEntityNameOptionTrait
{
    private function configureEntityNameOption(Command $command): void
    {
        $command->addOption(
            'entity-name',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'The name of the entity/entities for which the classes should be generated. The option can be used multiple times. If not set, all entities will be generated.',
            []
        );
    }
}
