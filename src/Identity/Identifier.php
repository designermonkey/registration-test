<?php

namespace Example\Identity;

interface Identifier
{
    /**
     * @return Identifier
     */
    public static function generate(): Identifier;

    /**
     * @param  Identifier $identifier
     * @return bool
     */
    public function equals(Identifier $identifier): bool;

    /**
     * @return string
     */
    public function __toString(): string;
}
