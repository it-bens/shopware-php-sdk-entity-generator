<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity;

use Symfony\Bundle\MakerBundle\Generator;
use Vin\ShopwareSdk\Data\Entity\EntityDefinition;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassName\NamespaceGeneratorInterface;

final class EntityMap
{
    /**
     * @var DefinitionClassInformation[]
     */
    private array $definitions;

    public function addDefinition(string $apiAlias, DefinitionClassInformation $definitionClassInformation): void
    {
        $this->definitions[$apiAlias] = $definitionClassInformation;
    }

    /**
     * @return array<string, class-string<EntityDefinition>>
     */
    public function generateEntityMapping(NamespaceGeneratorInterface $namespaceGenerator, Generator $generator): array
    {
        $mapping = [];
        foreach ($this->definitions as $apiAlias => $definitionClassInformation) {
            /** @var class-string<EntityDefinition> $fullClassName */
            $fullClassName = $definitionClassInformation->generateClassNameDetails($namespaceGenerator, $generator)->getFullName();
            $mapping[$apiAlias] = $fullClassName;
        }

        return $mapping;
    }
}
