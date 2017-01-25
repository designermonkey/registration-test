<?php

namespace Example\Model;

interface ValueObject
{
    /**
     * @param  ValueObject $valueObject
     * @return bool
     */
    public function equals(ValueObject $valueObject): bool;

    /**
     * @return string
     */
    public function __toString(): string;
}
