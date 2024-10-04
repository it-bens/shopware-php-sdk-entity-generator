<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassName\NamespaceGeneratorInterface;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorForSchemaProperty;
use Vin\ShopwareSdk\Data\Schema\Property;
use function Symfony\Component\String\u;

final readonly class ForToOneAssociation implements TypeGeneratorForSchemaProperty
{
    public function __construct(
        #[Autowire(env: 'SDK_NAMESPACE')]
        private string $sdkNamespace,
        private NamespaceGeneratorInterface $namespaceGenerator
    ) {
    }

    #[\Override]
    public function generateClassPropertyType(Property $schemaProperty, string $shopwareVersion): ?string
    {
        if ($schemaProperty->isToOneAssociation() === false) {
            return null;
        }

        $entityName = u($schemaProperty->entity)
            ->camel()
            ->title();
        $namespace = $this->sdkNamespace;
        $namespace .= $this->namespaceGenerator->generateClassNamespace((string) $entityName, $shopwareVersion);

        return $namespace . $entityName . 'Entity';
    }
}
