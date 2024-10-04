<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity;

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Bundle\MakerBundle\Util\UseStatementGenerator;
use Vin\ShopwareSdk\Data\Entity\Entity;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassName\NamespaceGeneratorInterface;

final class EntityClassInformation
{
    private const array TYPES_THAT_REQUIRE_NO_USE_STATEMENT = ['bool', 'float', 'int', 'array', 'string'];

    private const string CLASS_NAME_SUFFIX = 'Entity';

    /**
     * @var string[]|null
     */
    private static ?array $classPropertiesOfBaseClass = null;

    /**
     * @var string[]
     */
    private array $usedClasses = [];

    /**
     * @var array{type: string, name: string}[]
     */
    private array $properties = [];

    public function __construct(
        private readonly string $entityName,
        private readonly string $shopwareVersion
    ) {
        $this->usedClasses[] = Entity::class;
    }

    public function addProperty(string $fullyQualifiedType, string $propertyName): void
    {
        $type = $fullyQualifiedType;
        if (in_array($fullyQualifiedType, self::TYPES_THAT_REQUIRE_NO_USE_STATEMENT) === false && $fullyQualifiedType !== '') {
            $this->usedClasses[] = $fullyQualifiedType;
            $typeParts = explode('\\', $fullyQualifiedType);
            $type = end($typeParts);
        }

        $this->properties[] = [
            'type' => $type,
            'name' => $propertyName,
        ];
    }

    /**
     * @return string[]
     */
    public function getPropertiesWithoutBaseClassProperties(): array
    {
        $classPropertiesOfBaseClass = $this->getClassPropertiesOfBaseClass();

        $properties = [];
        foreach ($this->properties as $property) {
            if (in_array($property['name'], $classPropertiesOfBaseClass)) {
                continue;
            }

            $properties[] = sprintf('?%s $%s = null', $property['type'], $property['name']);
        }

        return $properties;
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
                'properties' => $this->getPropertiesWithoutBaseClassProperties(),
            ]
        );
    }

    /**
     * @return string[]
     */
    private function getClassPropertiesOfBaseClass(): array
    {
        if (is_array(self::$classPropertiesOfBaseClass)) {
            return self::$classPropertiesOfBaseClass;
        }

        $reflectionClass = new \ReflectionClass(Entity::class);
        $properties = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $properties[] = $property->getName();
        }

        self::$classPropertiesOfBaseClass = $properties;

        return $properties;
    }
}
