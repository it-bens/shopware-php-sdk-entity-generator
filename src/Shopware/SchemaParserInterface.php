<?php

namespace Vin\ShopwareSdkEntityGenerator\Shopware;

use Vin\ShopwareSdk\Data\Schema\SchemaCollection;

interface SchemaParserInterface
{
    public function parseSchema(array $schema): SchemaCollection;
}