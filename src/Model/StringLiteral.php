<?php

namespace Example\Model;

use InvalidArgumentException;

class StringLiteral implements ValueObject
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $value = filter_var($value, FILTER_SANITIZE_STRING);

        if (0 === strlen($value)) {
            throw new InvalidArgumentException(sprintf(
                "'%s' must be a valid non-zero length string.",
                $value
            ));
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param  ValueObject $object
     * @return bool
     */
    public function equals(ValueObject $object): bool
    {
        return $this->areEqualObjects($this, $object)
            && $this->areOfEqualValue($this, $object);
    }

    /**
     * @param  ValueObject $objectOne
     * @param  ValueObject $objectTwo
     * @return bool
     */
    private function areEqualObjects(ValueObject $objectOne, ValueObject $objectTwo): bool
    {
        return get_class($objectOne) === get_class($objectTwo);
    }

    /**
     * @param  ValueObject $objectOne
     * @param  ValueObject $objectTwo
     * @return bool
     */
    private function areOfEqualValue(ValueObject $objectOne, ValueObject $objectTwo): bool
    {
        return (string) $objectOne === (string) $objectTwo;
    }
}
