<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypeParameters;

class StringFieldTypeParameter extends AbstractFieldTypeParameter
{
    public function validate(int|string|array|null $value): bool
    {
        return is_string($value);
    }
}
