<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\PropertyDefinition\FlagValueGeneratorForFlagAndValue;

use Vin\ShopwareSdkEntityGenerator\Entity\PropertyDefinition\FlagValueGeneratorForFlagAndValue;

final readonly class ForStringValue implements FlagValueGeneratorForFlagAndValue
{
    #[\Override]
    public function generateFlagValueForConstructionString(string $flag, mixed $value): ?string
    {
        if (is_string($value) === false) {
            return null;
        }

        return '\'' . $value . '\'';
    }
}
