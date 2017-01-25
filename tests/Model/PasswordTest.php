<?php

namespace Example\Tests\Model;

use InvalidArgumentException;
use Example\Model\ValueObject;
use Example\Model\Password;
use Example\Tests\Model\DummyValueObject;

class PasswordTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstance()
    {
        $subject = $this->createInstanceWith('mushroom');

        $this->assertInstanceOf(ValueObject::class, $subject);
        $this->assertInstanceOf(Password::class, $subject);
    }

    public function testShouldNotAcceptLessThanEightCharacters()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->createInstanceWith('badger');
    }

    public function testShouldReturnStringValue()
    {
        $value = 'mushroom';
        $subject = $this->createInstanceWith($value);
        $this->assertSame($value, (string) $subject);
    }

    public function testInstanceEquality()
    {
        $value = 'mushroom';

        $subjectOne = $this->createInstanceWith($value);
        $subjectTwo = $this->createInstanceWith($value);
        $subjectThree = $this->createInstanceWith('badgerss');
        $subjectFour = new DummyValueObject;

        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
        $this->assertFalse($subjectOne->equals($subjectFour));
    }

    private function createInstanceWith($value)
    {
        return new Password($value);
    }
}
