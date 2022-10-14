<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Illuminate\Support\Collection;

class DateTimeType extends AbstractFieldType
{
    protected string $method = 'dateTime';

    public function __construct(
        private ?int $precision = 0
    ) {
    }

    protected function getParameters(): Collection
    {
        return (new Collection())->put('precision', $this->precision);
    }
}
