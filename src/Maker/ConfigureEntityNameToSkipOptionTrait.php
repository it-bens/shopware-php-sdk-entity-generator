<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Maker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

trait ConfigureEntityNameToSkipOptionTrait
{
    private function configureEntityNameToSkipOption(Command $command): void
    {
        $command->addOption(
            'entity-name-to-skip',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'The name of the entity/entities for which the classes should NOT be generated. The option can be used multiple times.',
            []
        );
    }
}
