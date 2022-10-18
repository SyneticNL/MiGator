<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypeParameters;

interface FieldTypeParameterInterface
{
    public function setValue(int|string|array|null $value): void;

    public function validate(int|string|array|null $value): bool;

    public function getValue(): int|string;
}
