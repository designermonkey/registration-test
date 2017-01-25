<?php

namespace Example\Tests\Model;

use Example\Model\ValueObject;

class DummyValueObject implements ValueObject
{
    /**
     * @param  ValueObject $object
     * @return bool
     */
    public function equals(ValueObject $object): bool
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
    }
}
