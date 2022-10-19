<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\FieldTypes;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Synetic\Migator\Domains\FieldTypeInterface;
use Synetic\Migator\Domains\FieldTypeParameters\FieldTypeParameterInterface;

abstract class AbstractFieldType implements FieldTypeInterface, \Stringable
{
    private string $label = '';

    protected string $method = '';

    private bool $hasDefaultValue = false;

    private mixed $defaultValue;

    protected Collection $parameters;

    public function __construct()
    {
        $this->parameters = collect([]);
    }

    /**
     * @return Collection<int, FieldTypeParameterInterface>
     */
    public function getParameters(): Collection
    {
        return $this->parameters;
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

        $methodParameters = $this->getMethodParameters();

        return Str::of($this->method)
            ->append('('.$column)
            ->when($methodParameters->isNotEmpty(), function (Stringable $string) use ($methodParameters) {
                return $string
                    ->append(', ')
                    ->append($methodParameters->join(', '));
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

    private function getMethodParameters(): Collection
    {
        $omitDefault = true;

        return $this->getParameters()
            ->reverse()
            ->filter(function (FieldTypeParameterInterface $parameter) use (&$omitDefault) {
                if ($omitDefault && $parameter->hasDefaultValue()) {
                    return false;
                }
                $omitDefault = false;

                return true;
            })
            ->reverse()
            ->map(fn (FieldTypeParameterInterface $parameter) => $parameter->getValue());
    }
}
