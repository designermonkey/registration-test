<?php

namespace Example\UserContext\Model;

use InvalidArgumentException;
use Example\Model\EmailAddress;
use Example\Model\Password;
use Example\Model\StringLiteral;
use Example\Model\DateOfBirth;
use Example\UserContext\Model\User;
use Example\UserContext\Model\UserId;

class UserFactory
{
    /**
     * @param  string|null $userId
     * @return UserId
     */
    public function createUserId(string $userId = null): UserId
    {
        return null === $userId ? UserId::generate() : new UserId($userId);
    }

    /**
     * @param  string $emailAddress
     * @return EmailAddress
     * @throws InvalidArgumentException
     */
    public function createEmailAddress(string $emailAddress): EmailAddress
    {
        return new EmailAddress($emailAddress);
    }

    /**
     * @param  string $password
     * @return Password
     * @throws InvalidArgumentException
     */
    public function createPassword(string $password): Password
    {
        return new Password($password);
    }

    /**
     * @param  string $name
     * @return StringLiteral
     * @throws InvalidArgumentException
     */
    public function createName(string $name): StringLiteral
    {
        return new StringLiteral($name);
    }

    /**
     * @param  string $year
     * @param  string $month
     * @param  string $day
     * @return DateOfBirth
     * @throws InvalidArgumentException
     */
    public function createDateOfBirth(string $year, string $month, string $day): DateOfBirth
    {
        return new DateOfBirth($year, $month, $day);
    }

    /**
     * @param  string $emailAddress
     * @param  string $password
     * @param  string $name
     * @param  string $dateOfBirth
     * @return User
     */
    public function createUser(string $emailAddress, string $password, string $name, string $dateOfBirth, string $userId = null): User
    {
        return new User(
            $this->createUserId($userId),
            $this->createEmailAddress($emailAddress),
            $this->createPassword($password),
            $this->createName($name),
            $this->createDateOfBirth($dateOfBirth)
        );
    }
}
