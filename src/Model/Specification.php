<?php

namespace Example\Model;

interface Specification
{
    /**
     * @param  ValueObject $valueObject
     * @return bool
     */
    public function isSatisfiedBy(ValueObject $valueObject): bool;
}
