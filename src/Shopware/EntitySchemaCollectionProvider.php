<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Shopware;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Vin\ShopwareSdk\Data\Schema\SchemaCollection;
use Vin\ShopwareSdk\Service\InfoService;

final readonly class EntitySchemaCollectionProvider implements EntitySchemaCollectionProviderInterface
{
    private Filesystem $filesystem;

    private SchemaParserInterface $schemaParser;

    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private string $projectDirectory,
        #[Autowire(env: 'SHOPWARE_ENTITY_SCHEMA_FOLDER_PATH')]
        private string $entitySchemaFolderPath
    ) {
        $this->filesystem = new Filesystem();
        $this->schemaParser = new SchemaParser();
    }

    #[\Override]
    public function getSchemaCollection(string $shopwareVersion): SchemaCollection
    {
        $entitySchemaFilePath = $this->projectDirectory . '/' . $this->entitySchemaFolderPath . 'entity-schema_' . $shopwareVersion . '.json';
        $entitySchemaFileContent = $this->filesystem->readFile($entitySchemaFilePath);
        $entitySchema = json_decode($entitySchemaFileContent, true);

        return $this->schemaParser->parseSchema($entitySchema);
    }
}
