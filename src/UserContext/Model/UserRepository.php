<?php

namespace Example\UserContext\Model;

interface UserRepository
{
    /**
     * @param User $user
     */
    public function addUser(User $user);
}
