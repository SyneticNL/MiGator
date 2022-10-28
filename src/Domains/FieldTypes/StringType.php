<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldTypeParameters\IntegerFieldTypeParameter;

class StringType extends AbstractFieldType
{
    protected string $method = 'string';

    public function __construct()
    {
        parent::__construct();
        $this->parameters = collect([
            new IntegerFieldTypeParameter('length', null, true),
        ]);
    }
}
