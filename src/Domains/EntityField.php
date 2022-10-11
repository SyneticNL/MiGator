<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

abstract class EntityField {

    public function __construct(
        public string $tableName,
        public string $tableType
    ) {
    }


}
