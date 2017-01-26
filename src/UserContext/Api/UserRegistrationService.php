<?php

namespace Example\UserContext\Api;

use Example\UserContext\Model\UserRepository;
use Example\UserContext\Model\UserFactory;

class UserRegistrationService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @param UserRepository $userRepository
     * @param UserFactory    $userFactory
     */
    public function __construct(UserRepository $userRepository, UserFactory $userFactory)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    public function registerUser(array $userData)
    {
        $user = $this->userFactory->createUser(
            $userData['emailAddress'],
            $userData['password']['password'],
            $userData['name'],
            explode('-', $userData['dateOfBirth'])
        );

        $this->userRepository->addUser($user);
    }
}
