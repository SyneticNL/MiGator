<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains;

class Field
{
    public function __construct(
        public string $name,
        public FieldTypeInterface $type
    ) {
    }
}
