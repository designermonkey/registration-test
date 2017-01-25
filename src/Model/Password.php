<?php

namespace Example\Model;

use InvalidArgumentException;

class Password extends StringLiteral
{
    const MINIMUM_LENGTH = 8;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (self::MINIMUM_LENGTH > strlen($value)) {
            throw new InvalidArgumentException(sprintf(
                "Password must be longer than %s characters.",
                self::MINIMUM_LENGTH
            ));
        }

        $this->value = $value;
    }
}
