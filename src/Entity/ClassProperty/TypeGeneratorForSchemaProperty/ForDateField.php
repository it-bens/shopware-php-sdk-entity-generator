<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

use Vin\ShopwareSdk\Data\Schema\Property;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

final readonly class ForDateField implements TypeGeneratorForSchemaProperty
{
    #[\Override]
    public function generateClassPropertyType(Property $schemaProperty, string $shopwareVersion): ?string
    {
        if ($schemaProperty->type !== 'date') {
            return null;
        }

        return \DateTimeInterface::class;
    }
}
