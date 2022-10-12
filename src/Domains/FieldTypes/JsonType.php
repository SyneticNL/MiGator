<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

class JsonType extends AbstractFieldType
{
    protected string $method = 'json';
}
