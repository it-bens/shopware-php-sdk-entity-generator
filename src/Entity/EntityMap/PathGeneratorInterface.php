<?php

declare(strict_types=1);

namespace Vin\ShopwareSdkEntityGenerator\Entity\EntityMap;

interface PathGeneratorInterface
{
    public function generatePath(string $shopwareVersion): string;
}
