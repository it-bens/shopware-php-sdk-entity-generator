<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

use Vin\ShopwareSdk\Data\Schema\Property;
use Vin\ShopwareSdk\Service\Struct\NotificationCollection;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

final readonly class ForToManyNotificationAssociation implements TypeGeneratorForSchemaProperty
{
    #[\Override]
    public function generateClassPropertyType(Property $schemaProperty, string $shopwareVersion): ?string
    {
        if ($schemaProperty->isToManyAssociation() === false) {
            return null;
        }
        if ($schemaProperty->entity !== 'notification') {
            return null;
        }

        return NotificationCollection::class;
    }
}
