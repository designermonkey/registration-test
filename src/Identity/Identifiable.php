<?php

namespace Example\Identity;

interface Identifiable
{
    /**
     * @return Identifier
     */
    public function identity(): Identifier;
}
