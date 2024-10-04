<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Finder\Finder;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassName\NamespaceGeneratorInterface;
use Vin\ShopwareSdkEntityGenerator\Entity\ClassProperty\TypeGeneratorInterface;
use Vin\ShopwareSdkEntityGenerator\Entity\CollectionClassInformation;
use Vin\ShopwareSdkEntityGenerator\Entity\DefinitionClassInformation;
use Vin\ShopwareSdkEntityGenerator\Entity\EntityClassInformation;
use Vin\ShopwareSdkEntityGenerator\Entity\PropertyDefinition\FlagGeneratorInterface;
use Vin\ShopwareSdk\Data\Schema\Property;
use Vin\ShopwareSdk\Data\Schema\Schema;
use Vin\ShopwareSdkEntityGenerator\Entity\PropertyDefinition\PropertiesGeneratorInterface;
use Vin\ShopwareSdkEntityGenerator\Shopware\EntitySchemaCollectionProviderInterface;
use function Symfony\Component\String\u;

final class MakeEntities extends AbstractMaker
{
    use ConfigureShopwareVersionArgumentTrait;

    private readonly Finder $finder;

    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDirectory,
        private readonly EntitySchemaCollectionProviderInterface $entitySchemaCollectionProvider,
        private readonly TypeGeneratorInterface $classPropertyTypeGenerator,
        private readonly FlagGeneratorInterface $flagGenerator,
        private readonly PropertiesGeneratorInterface $propertiesGenerator,
        private readonly NamespaceGeneratorInterface $namespaceGenerator
    ) {
        $this->finder = new Finder();
    }

    #[\Override]
    public static function getCommandName(): string
    {
        return 'make:shopware-sdk:entities';
    }

    public static function getCommandDescription(): string
    {
        return 'Create definition, entity and collection classes.';
    }

    #[\Override]
    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $this->configureShopwareVersionArgument($this->projectDirectory, $this->finder, $command);

        //$command->addArgument('entity-name', InputArgument::OPTIONAL, 'Choose an entity by its name. If no entity is chosen, the classes for all entities in the schema will be generated.');
    }

    #[\Override]
    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }

    #[\Override]
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $shopwareVersion = $input->getArgument('shopware-version');
        $entitySchemaCollection = $this->entitySchemaCollectionProvider->getSchemaCollection($shopwareVersion);

        /** @var Schema $entitySchema */
        foreach ($entitySchemaCollection->getElements() as $entitySchema) {
            $entityName = u($entitySchema->entity)
                ->camel()
                ->title();

            $entityClassInformation = new EntityClassInformation((string) $entityName, $shopwareVersion);
            $collectionClassInformation = new CollectionClassInformation(
                (string) $entityName,
                $shopwareVersion,
                $entityClassInformation
            );
            $definitionClassInformation = new DefinitionClassInformation(
                (string) $entityName,
                $shopwareVersion,
                $entitySchema->entity,
                $entityClassInformation,
                $collectionClassInformation
            );

            /** @var Property $property */
            foreach ($entitySchema->properties as $property) {
                $type = $this->classPropertyTypeGenerator->generateClassPropertyType($property, $shopwareVersion);
                $entityClassInformation->addProperty($type, $property->name);
                $definitionClassInformation->addProperty($property, $this->flagGenerator, $this->propertiesGenerator);
            }

            $entityClassInformation->generateClass(
                $this->namespaceGenerator,
                $generator,
                $this->projectDirectory . '/templates/Entity.tpl.php'
            );
            $collectionClassInformation->generateClass(
                $this->namespaceGenerator,
                $generator,
                $this->projectDirectory . '/templates/Collection.tpl.php'
            );
            $definitionClassInformation->generateClass(
                $this->namespaceGenerator,
                $generator,
                $this->projectDirectory . '/templates/Definition.tpl.php'
            );
        }

        $generator->writeChanges();
        $this->writeSuccessMessage($io);
    }
}
