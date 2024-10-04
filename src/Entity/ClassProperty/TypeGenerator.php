<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Vin\ShopwareSdk\Data\Schema\Property;

final readonly class TypeGenerator implements TypeGeneratorInterface
{
    /**
     * @param iterable<TypeGeneratorForSchemaProperty> $classPropertyTypeGenerators
     */
    public function __construct(
        #[AutowireIterator(TypeGeneratorForSchemaProperty::DI_SERVICE_TAG)]
        private iterable $classPropertyTypeGenerators
    ) {
    }

    #[\Override]
    public function generateClassPropertyType(Property $schemaProperty, string $shopwareVersion): string
    {
        foreach ($this->classPropertyTypeGenerators as $classPropertyTypeGenerator) {
            $classPropertyType = $classPropertyTypeGenerator->generateClassPropertyType($schemaProperty, $shopwareVersion);
            if ($classPropertyType !== null) {
                return $classPropertyType;
            }
        }

        throw new \RuntimeException(
            sprintf(
                'No class property type generator found for schema property %s of type %s',
                $schemaProperty->name,
                $schemaProperty->type
            )
        );
    }
}
