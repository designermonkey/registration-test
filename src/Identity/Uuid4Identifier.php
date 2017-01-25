<?php

namespace Example\Identity;

use Ramsey\Uuid\Uuid;
use Example\Identity\InvalidIdentifierException;

class Uuid4Identifier implements Identifier
{

    /**
     * @var string
     */
    private $value;

    /**
     * @return Identifier
     */
    public static function generate(): Identifier
    {
        return new static(strval(Uuid::uuid4()));
    }

    /**
     * @param  string $value
     * @throws InvalidIdentifierException
     */
    public function __construct(string $value)
    {
        if (!preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-4[0-9A-Fa-f]{3}-[89abAB][0-9A-Fa-f]{3}-[0-9A-Fa-f]{12}$/', $value)) {
            throw new InvalidIdentifierException(sprintf(
                "Value '%s' is not a valid UUID.",
                $value
            ));
        }

        $this->value = $value;
    }

    /**
     * @param  Identifier $identifier
     * @return bool
     */
    public function equals(Identifier $identifier): bool
    {
        return $this->areEqualObjects($this, $identifier)
            && $this->areOfEqualValue($this, $identifier);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param  Identifier $objectOne
     * @param  Identifier $objectTwo
     * @return bool
     */
    private function areEqualObjects(Identifier $objectOne, Identifier $objectTwo): bool
    {
        return get_class($objectOne) === get_class($objectTwo);
    }

    /**
     * @param  Identifier $objectOne
     * @param  Identifier $objectTwo
     * @return bool
     */
    private function areOfEqualValue(Identifier $objectOne, Identifier $objectTwo): bool
    {
        return (string) $objectOne === (string) $objectTwo;
    }
}
