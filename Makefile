dump-entity-schema:
	docker compose exec shopware-6.5.5.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.5.5.0.json
	docker compose exec shopware-6.5.6.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.5.6.0.json
	docker compose exec shopware-6.5.7.1 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.5.7.1.json
	docker compose exec shopware-6.5.8.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.5.8.0.json
	docker compose exec shopware-6.5.8.3 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.5.8.3.json
	docker compose exec shopware-6.5.8.8 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.5.8.8.json
	docker compose exec shopware-6.5.8.12 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.5.8.12.json
	docker compose exec shopware-6.6.0.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.6.0.0.json
	docker compose exec shopware-6.6.3.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.6.3.0.json
	docker compose exec shopware-6.6.4.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.6.4.0.json
	docker compose exec shopware-6.6.5.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.6.5.0.json
	docker compose exec shopware-6.6.6.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.6.6.0.json
	docker compose exec shopware-6.6.7.0 php bin/console framework:schema --schema-format=entity-schema --env=prod /tmp/data/entity-schema_6.6.7.0.json

create-entity-classes:
	php bin/console make:shopware-sdk:entities "6.5.5.0"
	php bin/console make:shopware-sdk:entities "6.5.6.0"
	php bin/console make:shopware-sdk:entities "6.5.7.1"
	php bin/console make:shopware-sdk:entities "6.5.8.0"
	php bin/console make:shopware-sdk:entities "6.5.8.3"
	php bin/console make:shopware-sdk:entities "6.5.8.8"
	php bin/console make:shopware-sdk:entities "6.5.8.12"
	php bin/console make:shopware-sdk:entities "6.6.0.0"
	php bin/console make:shopware-sdk:entities "6.6.3.0"
	php bin/console make:shopware-sdk:entities "6.6.4.0"
	php bin/console make:shopware-sdk:entities "6.6.5.0"
	php bin/console make:shopware-sdk:entities "6.6.6.0"
	php bin/console make:shopware-sdk:entities "6.6.7.0"