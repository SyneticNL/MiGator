<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypeParameters;

class IntegerFieldTypeParameter extends AbstractFieldTypeParameter
{
    public function validate(int|string|array|null $value): bool
    {
        return is_int($value);
    }
}
