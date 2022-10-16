<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Synetic\Migator\Domains\FieldTypeInterface;

abstract class AbstractFieldType implements FieldTypeInterface, \Stringable
{
    protected string $label = '';

    protected string $method = '';

    protected bool $hasDefaultValue = false;

    protected mixed $defaultValue;

    protected function getParameters(): Collection
    {
        return new Collection();
    }

    public function setDefault(mixed $default): static
    {
        $this->hasDefaultValue = true;
        $this->defaultValue = $default;

        return $this;
    }

    public function toMigrationString(string $column): string
    {
        if ($this instanceof IdType && $column === 'id') {
            $column = '';
        }

        if ($column) {
            $column = '\''.$column.'\'';
        }

        return Str::of($this->method)
            ->append('('.$column)
            ->when($this->getParameters()->isNotEmpty(), function (Stringable $string) {
                return $string
                    ->append(', ')
                    ->append(
                        $this->getParameters()
                            ->map(fn ($value, $key) => sprintf('$%s = %s', $key, $value ?? 'null'))
                            ->join(', ')
                    );
            })
            ->append(')')
            ->when($this->hasDefaultValue, function (Stringable $string) {
                return $string->append('->default(%s)')->replace('%s', $this->getDefaultValueString());
            })
            ->toString();
    }

    private function getDefaultValueString(): string
    {
        $default = $this->defaultValue;

        if (is_string($default)) {
            $default = sprintf('\'%s\'', $default);
        }

        if (is_bool($default)) {
            $default = $default ? 'true' : 'false';
        }

        return (string) ($default ?? 'null');
    }

    public function __toString(): string
    {
        return $this->label ?: $this->method;
    }
}
