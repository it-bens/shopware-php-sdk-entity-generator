# Shopware SDK Entity Generator

## Entity schema export

> [!WARNING]  
> Starting all service pulls a lot of Shopware images and can take up tens of gigabytes of disk space.

This repository contains a docker compose configuration with service for (nearly) all Shopware versions since 6.5.5.0.

To dump the entity schema the Shopware container must be started first. The following command dumps the schema for Shopware 6.5.5.0.

```bash
docker compose exec shopware-6.5.5.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.5.5.0.json
```

Most Shopware versions contain no entity changes. I "keep" only the lowest version that contains the changes. The rest is moved to the `data/redundant` directory.

## Class generation

This tool uses the Symfony Maker bundle to create definition, entity and collection classes. The information is drawn from exported entity schema files.

The make command supports white- and blacklisting of entities. The following command generates classes for all entities in the schema file. The Shopware version is mandatory as an argument.

```bash
php bin/console make:shopware-sdk:entities "6.5.5.0"
```

The white- and blacklisting options can be passed several times to apply the option to server entities.

```bash
php bin/console make:shopware-sdk:entities "6.5.5.0" --entity-name=product --entity-name=customer
php bin/console make:shopware-sdk:entities "6.5.5.0" --entity-name-to-skip=product --entity-name-to-skip=customer
```

The make command will create the classes in the namespace of the Shopware SDK package also also puts the files there. The namespace of the classes contains the Shopware version with a "v" prefix and without the dots.

## Entity mapping export

The make command also creates an entity mapping file which is required by the Shopware SDK package. The file name contains the Shopware version. The mapping file is put in the `Resource` folder of the Shopware SDK package.

The export is currently disabled if white- or blacklisting is used.