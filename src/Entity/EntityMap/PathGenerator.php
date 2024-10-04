<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\EntityMap;

use Composer\InstalledVersions;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class PathGenerator implements PathGeneratorInterface
{
    public function __construct(
        #[Autowire(env: 'SDK_PACKAGE_NAME')]
        private string $sdkPackageName,
    ) {
    }

    #[\Override]
    public function generatePath(string $shopwareVersion): string
    {
        $sdkPackagePath = InstalledVersions::getInstallPath($this->sdkPackageName);
        $entityMappingName = sprintf('entity_mapping_%s.json', $shopwareVersion);

        return $sdkPackagePath . '/src/Resources/' . $entityMappingName;
    }
}
