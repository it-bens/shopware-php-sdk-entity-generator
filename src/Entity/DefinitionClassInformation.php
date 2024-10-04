<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity;

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Bundle\MakerBundle\Util\UseStatementGenerator;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassName\NamespaceGeneratorInterface;
use Vin\ShopwareSdkEntityGenerator\Entity\PropertyDefinition\FlagGeneratorInterface;
use Vin\ShopwareSdkEntityGenerator\Entity\PropertyDefinition\PropertiesGeneratorInterface;
use Vin\ShopwareSdk\Data\Entity\EntityDefinition;
use Vin\ShopwareSdk\Data\Schema\Flag;
use Vin\ShopwareSdk\Data\Schema\FlagCollection;
use Vin\ShopwareSdk\Data\Schema\Property;
use Vin\ShopwareSdk\Data\Schema\PropertyCollection;
use Vin\ShopwareSdk\Data\Schema\Schema;

final class DefinitionClassInformation
{
    private const string CLASS_NAME_SUFFIX = 'Definition';

    private const int PROPERTY_INDENTATION_WHITESPACE_COUNT = 16;

    /**
     * @var string[]
     */
    private array $usedClasses = [];

    /**
     * @var array{name: string, type: string, flags: string, properties: string}[]
     */
    private array $properties;

    public function __construct(
        private readonly string $entityName,
        private readonly string $shopwareVersion,
        private readonly string $apiAlias,
        private readonly EntityClassInformation $entityClassInformation,
        private readonly CollectionClassInformation $collectionClassInformation,
    ) {
        $this->usedClasses[] = EntityDefinition::class;
        $this->usedClasses[] = Schema::class;
        $this->usedClasses[] = PropertyCollection::class;
        $this->usedClasses[] = Property::class;
        $this->usedClasses[] = FlagCollection::class;
        $this->usedClasses[] = Flag::class;
    }

    public function addProperty(Property $schemaProperty, FlagGeneratorInterface $flagGenerator, PropertiesGeneratorInterface $propertiesGenerator): void
    {
        $property = [
            'name' => '\'' . $schemaProperty->name . '\'',
            'type' => '\'' . $schemaProperty->type . '\'',
        ];

        $flatConstructionStrings = [];
        /** @var Flag $flag */
        foreach ($schemaProperty->flags as $flag) {
            $flatConstructionStrings[] = $flagGenerator->generateFlagConstructionString($flag->flag, $flag->value);
        }
        $property['flags'] = sprintf('new FlagCollection([%s])', implode(', ', $flatConstructionStrings));

        $property['properties'] = $propertiesGenerator->generatePropertiesArrayString(
            $schemaProperty->entity,
            $schemaProperty->referenceField,
            $schemaProperty->localField,
            $schemaProperty->relation,
            $schemaProperty->properties,
            self::PROPERTY_INDENTATION_WHITESPACE_COUNT
        );

        $this->properties[$schemaProperty->name] = $property;
    }

    public function generateClassNameDetails(NamespaceGeneratorInterface $namespaceGenerator, Generator $generator): ClassNameDetails
    {
        $namespace = $namespaceGenerator->generateClassNamespace($this->entityName, $this->shopwareVersion);

        return $generator->createClassNameDetails($this->entityName, $namespace, self::CLASS_NAME_SUFFIX);
    }

    public function generateClass(NamespaceGeneratorInterface $namespaceGenerator, Generator $generator, string $templatePath): void
    {
        $generator->generateClass(
            $this->generateClassNameDetails($namespaceGenerator, $generator)
                ->getFullName(),
            $templatePath,
            [
                'use_statements' => new UseStatementGenerator($this->usedClasses),
                'api_alias' => $this->apiAlias,
                'entity_class' => $this->entityClassInformation->generateClassNameDetails($namespaceGenerator, $generator)
                    ->getRelativeName(),
                'collection_class' => $this->collectionClassInformation->generateClassNameDetails($namespaceGenerator, $generator)
                    ->getRelativeName(),
                'properties' => $this->properties,
            ]
        );
    }
}
