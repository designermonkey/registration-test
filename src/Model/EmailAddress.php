<?php

namespace Example\Model;

use InvalidArgumentException;

class EmailAddress extends StringLiteral
{
    /**
     * @param  string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        $value = filter_var($value, FILTER_SANITIZE_EMAIL);

        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf(
                "'%s' is not a valid email address.",
                $value
            ));
        }

        $this->value = $value;
    }
}
