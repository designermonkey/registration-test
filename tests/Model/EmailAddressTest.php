<?php

namespace Example\Tests\Model;

use InvalidArgumentException;
use Example\Model\ValueObject;
use Example\Model\EmailAddress;

class EmailAddressTest extends \PHPUnit_Framework_TestCase
{
    const VALID_EMAIL_ADDRESS = 'test@domain.net';
    const VALID_EMAIL_ADDRESS_TWO = 'test.test@domain.net';
    const INVALID_EMAIL_ADDRESS = 'test@domain';

    public function testShouldCreateInstance()
    {
        $subject = $this->createInstanceWith(self::VALID_EMAIL_ADDRESS);

        $this->assertInstanceOf(ValueObject::class, $subject);
        $this->assertInstanceOf(EmailAddress::class, $subject);
    }

    public function testShouldReturnStringValue()
    {
        $subject = $this->createInstanceWith(self::VALID_EMAIL_ADDRESS);
        $this->assertSame(self::VALID_EMAIL_ADDRESS, (string) $subject);
    }

    public function testInstanceEquality()
    {
        $subjectOne = $this->createInstanceWith(self::VALID_EMAIL_ADDRESS);
        $subjectTwo = $this->createInstanceWith(self::VALID_EMAIL_ADDRESS);
        $subjectThree = $this->createInstanceWith(self::VALID_EMAIL_ADDRESS_TWO);
        $subjectFour = new DummyValueObject;

        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
        $this->assertFalse($subjectOne->equals($subjectFour));
    }

    public function testShouldValidateEmailAddress()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->createInstanceWith(self::INVALID_EMAIL_ADDRESS);
    }

    public function testShouldReturnPlainString()
    {
        $subject = $this->createInstanceWith(self::VALID_EMAIL_ADDRESS);
        $this->assertEquals(self::VALID_EMAIL_ADDRESS, (string) $subject);
    }

    private function createInstanceWith($value)
    {
        return new EmailAddress($value);
    }
}
