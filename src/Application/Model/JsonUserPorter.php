<?php

namespace Example\Application\Model;

use Example\UserContext\Model\User;
use Example\UserContext\Model\UserFactory;
use Example\UserContext\Model\UserPorter;

class JsonUserPorter implements UserPorter
{
    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var array
     */
    private $defaults;

    /**
     * @param UserFactory $userFactory
     */
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
        $this->defaults = [
            'emailAddress' => '',
            'password' => '',
            'name' => '',
            'dateOfBirth' => '',
        ];
    }

    /**
     * @param  mixed $data
     * @return User
     */
    public function importUser($data): User
    {
        $data = array_merge($this->defaults, $data);

        return $this->userFactory->createUser(
            $data['emailAddress'],
            $data['password'],
            $data['name'],
            $data['dateOfBirth'],
            isset($data['userId']) ? $data['userId'] : null
        );
    }

    /**
     * @param  User   $user
     * @return mixed
     */
    public function exportUser(User $user)
    {
        return json_encode($user);
    }
}
