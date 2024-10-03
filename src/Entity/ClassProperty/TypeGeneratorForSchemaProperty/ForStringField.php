<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

use Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;
use Vin\ShopwareSdk\Data\Schema\Property;

final readonly class ForStringField implements TypeGeneratorForSchemaProperty
{
    #[\Override]
    public function generateClassPropertyType(Property $schemaProperty): ?string
    {
        if ($schemaProperty->isStringField() === false) {
            return null;
        }

        return 'string';
    }
}
