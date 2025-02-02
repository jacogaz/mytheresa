<?php

namespace App\Domain\ValueObject;

class FloatValueObject
{
    private float $value;

    public function __construct($value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('El valor debe ser un número válido.');
        }

        $this->value = (float) $value;

        if ($this->value < 0) {
            throw new \InvalidArgumentException('El número debe ser positivo.');
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
