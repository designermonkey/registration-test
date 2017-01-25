<?php

namespace Example\UserContext\Model;

interface UserPorter
{
    /**
     * @param  mixed $data
     * @return User
     */
    public function importUser($data): User;

    /**
     * @param  User   $user
     * @return mixed
     */
    public function exportUser(User $user);
}
