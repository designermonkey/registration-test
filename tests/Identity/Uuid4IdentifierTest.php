<?php

namespace Example\Tests\Identity;

use Example\Identity\Uuid4Identifier;
use Example\Identity\InvalidIdentifierException;
use Example\Tests\Identity\Uuid4IdentifierDummy;

class Uuid4IdentifierTest extends \PHPUnit_Framework_TestCase
{
    const INVALID_UUID = '00000000-0000-0000-0000-000000000000';
    const VALID_UUID = '809041d8-f6ae-4aa1-9d0c-9de5df2539a3';
    const VALID_UUID_TWO = '809041d8-f6ae-4aa1-9d0c-9de6df2539a3';

    public function testShouldCreateInstance()
    {
        $subject = $this->createInstance();
        $this->assertInstanceOf(Uuid4Identifier::class, $subject);
    }

    public function testShouldCreateInstanceFromString()
    {
        $subject = $this->createInstanceFromString(self::VALID_UUID);
        $this->assertInstanceOf(Uuid4Identifier::class, $subject);
    }

    public function testShouldThrowExceptionFromInvalidString()
    {
        $this->setExpectedException(InvalidIdentifierException::class);
        $this->createInstanceFromString(self::INVALID_UUID);
    }

    public function testInstanceEquality()
    {
        $subjectOne = $this->createInstanceFromString(self::VALID_UUID);
        $subjectTwo = $this->createInstanceFromString(self::VALID_UUID);
        $subjectThree = $this->createDifferentInstanceFromString(self::VALID_UUID_TWO);
        $subjectFour = $this->createInstance();

        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
        $this->assertFalse($subjectOne->equals($subjectFour));
    }

    public function testShouldConvertToString()
    {
        $subject = $this->createInstanceFromString(self::VALID_UUID);
        $this->assertEquals(self::VALID_UUID, (string) $subject);
    }

    private function createInstance()
    {
        return Uuid4Identifier::generate();
    }

    private function createInstanceFromString(string $string)
    {
        return new Uuid4Identifier($string);
    }

    private function createDifferentInstanceFromString(string $string)
    {
        return new Uuid4IdentifierDummy($string);
    }
}
