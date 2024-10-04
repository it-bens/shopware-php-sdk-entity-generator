<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassName;

final readonly class NamespaceGenerator implements NamespaceGeneratorInterface
{
    #[\Override]
    public function generateClassNamespace(string $entityName, string $shopwareVersion): string
    {
        $classNameCompatibleShopwareVersion = str_replace('.', '', $shopwareVersion);

        return sprintf('Data\\Entity\\v%s\\%s\\', $classNameCompatibleShopwareVersion, $entityName);
    }
}
