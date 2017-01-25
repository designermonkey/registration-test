<?php

namespace Example\Application\Model;

use Directory;
use RuntimeException;
use Example\UserContext\Model\UserRepository;
use Example\UserContext\Model\UserPorter;

class FileBasedUserRepository implements UserRepository
{
    /**
     * @var Directory
     */
    private $storageDirectory;

    /**
     * @var UserPorter
     */
    private $userPorter;

    /**
     * @param Directory  $storageDirectory
     * @param UserPorter $userPorter
     */
    public function __construct(Directory $storageDirectory, UserPorter $userPorter)
    {
        $this->storageDirectory = $storageDirectory;
        $this->userPorter = $userPorter;
    }

    /**
     * @param User $user
     * @throws RuntimeException
     */
    public function addUser(User $user)
    {
        $filename = implode('/', [
            $this->storageDirectory->path,
            $user->identity()
        ]).'.json';

        $contents = $this->userPorter->export($user);

        if (!file_put_contents($filename, $contents)) {
            throw new RuntimeException(sprintf(
                "Could not write user with ID '%s' to disk."
            ));
        }
    }
}
