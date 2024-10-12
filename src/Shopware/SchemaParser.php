<?php

namespace Vin\ShopwareSdkEntityGenerator\Shopware;

use Vin\ShopwareSdk\Data\Schema\Schema;
use Vin\ShopwareSdk\Data\Schema\SchemaCollection;

final class SchemaParser implements SchemaParserInterface
{
    public function parseSchema(array $schema): SchemaCollection
    {
        $schemaCollection = [];

        foreach ($schema as $keySchema => $item) {
            $schemaCollection[$keySchema] = Schema::createFromRaw($item['entity'], $item['properties']);
        }

        return new SchemaCollection($schemaCollection);
    }
}