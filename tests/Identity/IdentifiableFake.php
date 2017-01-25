<?php

namespace Example\Tests\Identity;

use Example\Identity\Identifiable;
use Example\Identity\HasIdentity;
use Example\Identity\Identifier;

class IdentifiableFake implements Identifiable
{
    use HasIdentity;

    /**
     * @param Identifier $identity
     */
    public function __construct(Identifier $identity)
    {
        $this->setIdentity($identity);
    }
}
