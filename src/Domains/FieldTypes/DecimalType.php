<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldTypeParameters\IntegerFieldTypeParameter;

class DecimalType extends AbstractFieldType
{
    protected string $method = 'decimal';

    public function __construct()
    {
        parent::__construct();
        $this->parameters = collect([
            new IntegerFieldTypeParameter('precision', 8),
            new IntegerFieldTypeParameter('scale', 2),
        ]);
    }
}
