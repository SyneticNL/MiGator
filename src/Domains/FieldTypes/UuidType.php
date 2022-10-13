<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

class UuidType extends AbstractFieldType
{
    protected string $method = 'uuid';
}
