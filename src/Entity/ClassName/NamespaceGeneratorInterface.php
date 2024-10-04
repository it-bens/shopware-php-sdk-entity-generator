<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\ClassName;

interface NamespaceGeneratorInterface
{
    public function generateClassNamespace(string $entityName, string $shopwareVersion): string;
}
