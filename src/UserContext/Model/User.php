<?php

namespace Example\UserContext\Model;

use Example\Identity\Identifiable;
use Example\Identity\HasIdentity;
use Example\Model\EmailAddress;
use Example\Model\Password;
use Example\Model\StringLiteral;
use Example\Model\DateOfBirth;

class User implements Identifiable
{
    use HasIdentity;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    /**
     * @var Password
     */
    private $password;

    /**
     * @var StringLiteral
     */
    private $name;

    /**
     * @var DateOfBirth
     */
    private $dateOfBirth;

    /**
     * @param UserID        $userId
     * @param EmailAddress  $emailAddress
     * @param Password      $password
     * @param StringLiteral $name
     * @param DateOfBirth   $dateOfBirth
     */
    public function __construct(UserId $userId, EmailAddress $emailAddress, Password $password, StringLiteral $name, DateOfBirth $dateOfBirth)
    {
        $this->setIdentity($userId);

        $this->emailAddress = $emailAddress;
        $this->password = $password;
        $this->name = $name;
        $this->dateOfBirth = $dateOfBirth;
    }
}
