<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

use Vin\ShopwareSdk\Data\Schema\Property;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

final readonly class ForRemoteAddressField implements TypeGeneratorForSchemaProperty
{
    #[\Override]
    public function generateClassPropertyType(Property $schemaProperty, string $shopwareVersion): ?string
    {
        if ($schemaProperty->type !== 'Shopware\Core\Framework\DataAbstractionLayer\Field\RemoteAddressField') {
            return null;
        }

        return 'string';
    }
}
