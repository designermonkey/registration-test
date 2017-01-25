<?php

namespace Example\Model;

use DateTimeImmutable;
use InvalidArgumentException;

class DateOfBirth implements ValueObject
{
    const DATE_FORMAT = 'Y/m/d';

    /**
     * @var DateTimeImmutable
     */
    private $value;

    /**
     * @param string $year
     * @param string $month
     * @param string $day
     */
    public function __construct(string $year, string $month, string $day)
    {
        $this->testValue($year, 'year', 4);
        $this->testValue($month, 'month', 2);
        $this->testValue($day, 'day', 2);

        $this->value = DateTimeImmutable::createFromFormat(
            self::DATE_FORMAT,
            implode('/', [$year, $month, $day])
        );
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value->format(self::DATE_FORMAT);
    }

    /**
     * @param  ValueObject $object
     * @return bool
     */
    public function equals(ValueObject $object): bool
    {
        return $this->areEqualObjects($this, $object)
            && $this->areOfEqualValue($this, $object);
    }

    /**
     * @return string
     */
    public function year(): string
    {
        return $this->value->format('Y');
    }

    /**
     * @return string
     */
    public function month(): string
    {
        return $this->value->format('m');
    }

    /**
     * @return string
     */
    public function day(): string
    {
        return $this->value->format('d');
    }

    /**
     * @param  ValueObject $objectOne
     * @param  ValueObject $objectTwo
     * @return bool
     */
    private function areEqualObjects(ValueObject $objectOne, ValueObject $objectTwo): bool
    {
        return get_class($objectOne) === get_class($objectTwo);
    }

    /**
     * @param  ValueObject $objectOne
     * @param  ValueObject $objectTwo
     * @return bool
     */
    private function areOfEqualValue(ValueObject $objectOne, ValueObject $objectTwo): bool
    {
        return (string) $objectOne === (string) $objectTwo;
    }

    /**
     * @param  string $value
     * @param  string $type
     * @param  int    $length
     * @throws InvalidArgumentException
     */
    private function testValue(string $value, string $type, int $length)
    {
        if (empty($value) || $length > strlen($value)) {
            throw new InvalidArgumentException(sprintf(
                "The provided %s must not be empty and must be %s characters.",
                $type,
                $length
            ));
        }
    }
}
