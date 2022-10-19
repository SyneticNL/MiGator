<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypeParameters;

abstract class AbstractFieldTypeParameter implements FieldTypeParameterInterface
{
    private bool $hasValue = false;

    private int|string|array|null $value;

    public function __construct(
        private string $label,
        private int|string|array|null $default,
        private bool $nullable = false
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function setValue(int|string|array|null $value): void
    {
        $isValid = ($this->nullable && $value === null) || $this->validate($value);

        throw_if(! $isValid, new \UnexpectedValueException('Invalid parameter value for '.$this->label));

        $this->hasValue = true;
        $this->value = $value;
    }

    public function getValue(): int|string
    {
        $value = $this->hasValue ? $this->value : $this->default;

        if (is_string($value)) {
            $value = $this->addQuotes($value);
        }

        if (is_array($value)) {
            $values = collect($value)
                ->map(fn ($value) => $this->addQuotes((string) $value))
                ->implode(', ');
            $value = '['.$values.']';
        }

        return $value ?? 'null';
    }

    public function hasDefaultValue(): bool
    {
        if (! $this->hasValue) {
            return true;
        }

        return $this->value === $this->default;
    }

    private function addQuotes(string $value): string
    {
        return '\''.$value.'\'';
    }
}
