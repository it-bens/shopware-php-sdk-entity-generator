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

    private InfoService $infoService;

    public function __construct(
        #[Autowire(env: 'SHOPWARE_ENTITY_SCHEMA_FILE_PATH')]
        private string $entitySchemaFilePath
    ) {
        $this->filesystem = new Filesystem();
        $this->infoService = new InfoService();
    }

    public function getSchemaCollection(): SchemaCollection
    {
        $entitySchemaFileContent = $this->filesystem->readFile('../' . $this->entitySchemaFilePath);
        /** @phpstan-ignore-next-line */
        $entitySchema = json_decode($entitySchemaFileContent, true);

        return $this->infoService->parseSchema($entitySchema);
    }
}
