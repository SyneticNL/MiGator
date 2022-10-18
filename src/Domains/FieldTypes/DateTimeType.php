<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Synetic\Migator\Domains\FieldTypeParameters\IntegerFieldTypeParameter;

class DateTimeType extends AbstractFieldType
{
    protected string $label = 'date-time';

    protected string $method = 'dateTime';

    public function __construct()
    {
        parent::__construct();
        $this->parameters = collect([
            new IntegerFieldTypeParameter('precision', 0, true)
        ]);
    }
}
