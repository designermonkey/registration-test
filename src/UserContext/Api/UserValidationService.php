<?php

namespace Example\UserContext\Api;

use InvalidArgumentException;
use Example\Model\Specification;
use Example\UserContext\Model\UserRepository;
use Example\UserContext\Model\UserFactory;

class UserValidationService
{
    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var Specification
     */
    private $passwordSpecification;

    /**
     * @param UserFactory    $userFactory
     */
    public function __construct(UserFactory $userFactory, Specification $passwordSpecification)
    {
        $this->userFactory = $userFactory;
        $this->passwordSpecification = $passwordSpecification;
    }

    /**
     * @param  string $emailAddress
     * @return array
     */
    public function validateEmailAddress(string $emailAddress): array
    {
        try {
            $createdEmailAddress = $this->userFactory->createEmailAddress($emailAddress);
        } catch (InvalidArgumentException $exception) {
            return [
                'message' => $exception->getMessage(),
                'valid' => false,
                'emailAddress' => $emailAddress
            ];
        }

        return [
            'valid' => true,
            'emailAddress' => (string) $createdEmailAddress
        ];
    }

    /**
     * @param  string $password
     * @return array
     */
    public function validatePassword(string $password): array
    {
        try {
            $createdPassword = $this->userFactory->createPassword($password);

            if (!$this->passwordSpecification->isSatisfiedBy($createdPassword)) {
                throw new InvalidArgumentException("Supplied password is not allowed.");
            }
        } catch (InvalidArgumentException $exception) {
            return [
                'message' => $exception->getMessage(),
                'valid' => false,
                'password' => $password
            ];
        }

        return [
            'valid' => true,
            'password' => (string) $createdPassword
        ];
    }

    /**
     * @param  string $name
     * @return array
     */
    public function validateName(string $name): array
    {
        try {
            $createdName = $this->userFactory->createName($name);
        } catch (InvalidArgumentException $exception) {
            return [
                'message' => $exception->getMessage(),
                'valid' => false,
                'name' => $name
            ];
        }

        return [
            'valid' => true,
            'name' => (string) $createdName
        ];
    }

    public function validateDateOfBirth(string $dateOfBirth): array
    {
        try {
            $parts = explode('/', $dateOfBirth);
            $createdDateOfBirth = $this->userFactory->createDateOfBirth(...$parts);
        } catch (InvalidArgumentException $exception) {
            return [
                'message' => $exception->getMessage(),
                'valid' => false,
                'dateOfBirth' => $dateOfBirth
            ];
        }

        return [
            'valid' => true,
            'dateOfBirth' => (string) $createDateOfBirth
        ];
    }
}
