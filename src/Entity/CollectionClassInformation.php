<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity;

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Bundle\MakerBundle\Util\UseStatementGenerator;
use Vin\ShopwareSdk\Data\Entity\EntityCollection;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassName\NamespaceGeneratorInterface;

final class CollectionClassInformation
{
    private const string CLASS_NAME_SUFFIX = 'Collection';

    /**
     * @var string[]
     */
    private array $usedClasses = [];

    public function __construct(
        private readonly string $entityName,
        private readonly string $shopwareVersion,
        private readonly EntityClassInformation $entityClassInformation,
    ) {
        $this->usedClasses[] = EntityCollection::class;
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
                'entity_class' => $this->entityClassInformation->generateClassNameDetails($namespaceGenerator, $generator)
                    ->getRelativeName(),
            ]
        );
    }
}
