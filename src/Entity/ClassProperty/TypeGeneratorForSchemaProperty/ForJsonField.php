<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

use Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;
use Vin\ShopwareSdk\Data\Schema\Property;

final readonly class ForJsonField implements TypeGeneratorForSchemaProperty
{
    #[\Override]
    public function generateClassPropertyType(Property $schemaProperty): ?string
    {
        if ($schemaProperty->isJsonField() === false) {
            return null;
        }

        return 'array';
    }
}
