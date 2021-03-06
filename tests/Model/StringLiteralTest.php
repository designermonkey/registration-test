<?php

namespace Example\Tests\Model;

use InvalidArgumentException;
use Example\Model\ValueObject;
use Example\Model\StringLiteral;
use Example\Tests\Model\DummyValueObject;

class StringLiteralTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstance()
    {
        $subject = $this->createInstanceWith('mushroom');

        $this->assertInstanceOf(ValueObject::class, $subject);
        $this->assertInstanceOf(StringLiteral::class, $subject);
    }

    public function testShouldNotAcceptEmptyValue()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->createInstanceWith('');
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
        $subjectThree = $this->createInstanceWith('badger');
        $subjectFour = new DummyValueObject;

        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
        $this->assertFalse($subjectOne->equals($subjectFour));
    }

    private function createInstanceWith($value)
    {
        return new StringLiteral($value);
    }
}
