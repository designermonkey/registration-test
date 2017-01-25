<?php

namespace Example\Tests\Identity;

use Example\Identity\Identifiable;
use Example\Tests\Identity\IdentifiableFake;
use Example\Tests\Identity\Uuid4IdentifierDummy;

class HasIdentityTest extends \PHPUnit_Framework_TestCase
{
    public function testHasIdentity()
    {
        $uuid = Uuid4IdentifierDummy::generate();
        $subject = new IdentifiableFake($uuid);

        $this->assertInstanceOf(Identifiable::class, $subject);
        $this->assertSame($uuid, $subject->identity());
    }
}
