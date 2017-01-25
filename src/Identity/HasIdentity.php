<?php

namespace Example\Identity;

trait HasIdentity
{
    /**
     * @var Identifier
     */
    private $identity;

    /**
     * @param Identifier $identity
     */
    private function setIdentity(Identifier $identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return Identifier
     */
    public function identity(): Identifier
    {
        return $this->identity;
    }
}
