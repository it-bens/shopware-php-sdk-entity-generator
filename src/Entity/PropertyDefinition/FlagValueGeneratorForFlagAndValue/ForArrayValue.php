<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\PropertyDefinition\FlagValueGeneratorForFlagAndValue;

use Vin\ShopwareSdkEntityGenerator\Entity\PropertyDefinition\FlagValueGeneratorForFlagAndValue;

final readonly class ForArrayValue implements FlagValueGeneratorForFlagAndValue
{
    #[\Override]
    public function generateFlagValueForConstructionString(string $flag, mixed $value): ?string
    {
        if (is_array($value) === false) {
            return null;
        }

        if ($flag === 'read_protected' || $flag === 'write_protected') {
            return null;
        }

        return sprintf('unserialize(\'%s\')', addslashes(serialize($value)));
    }
}
