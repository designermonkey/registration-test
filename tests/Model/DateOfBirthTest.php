<?php

namespace Example\Tests\Model;

use InvalidArgumentException;
use Example\Model\ValueObject;
use Example\Model\DateOfBirth;
use Example\Tests\Model\DummyValueObject;

class DateOfBirthTest extends \PHPUnit_Framework_TestCase
{
    const YEAR = '1979';

    const MONTH = '07';

    const DAY = '02';

    const FULL_DATE = '1979/07/02';

    public function testShouldCreateInstance()
    {
        $subject = $this->createInstanceWith(self::YEAR, self::MONTH, self::DAY);

        $this->assertInstanceOf(ValueObject::class, $subject);
        $this->assertInstanceOf(DateOfBirth::class, $subject);
    }

    public function testShouldNotAcceptEmptyYear()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->createInstanceWith('', self::MONTH, self::DAY);
    }

    public function testShouldNotAcceptEmptyMonth()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->createInstanceWith(self::YEAR, '', self::DAY);
    }

    public function testShouldNotAcceptEmptyDay()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->createInstanceWith(self::YEAR, self::MONTH, '');
    }

    public function testShouldReturnStringValue()
    {
        $subject = $this->createInstanceWith(self::YEAR, self::MONTH, self::DAY);
        $this->assertSame(self::FULL_DATE, (string) $subject);
    }

    public function testShouldReturnYear()
    {
        $subject = $this->createInstanceWith(self::YEAR, self::MONTH, self::DAY);
        $this->assertSame(self::YEAR, $subject->year());
    }

    public function testShouldReturnMonth()
    {
        $subject = $this->createInstanceWith(self::YEAR, self::MONTH, self::DAY);
        $this->assertSame(self::MONTH, $subject->month());
    }

    public function testShouldReturnDay()
    {
        $subject = $this->createInstanceWith(self::YEAR, self::MONTH, self::DAY);
        $this->assertSame(self::DAY, $subject->day());
    }

    public function testInstanceEquality()
    {
        $subjectOne = $this->createInstanceWith(self::YEAR, self::MONTH, self::DAY);
        $subjectTwo = $this->createInstanceWith(self::YEAR, self::MONTH, self::DAY);
        $subjectThree = $this->createInstanceWith(self::YEAR, '08', self::DAY);
        $subjectFour = new DummyValueObject;

        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
        $this->assertFalse($subjectOne->equals($subjectFour));
    }

    private function createInstanceWith($year, $month, $day)
    {
        return new DateOfBirth($year, $month, $day);
    }
}
