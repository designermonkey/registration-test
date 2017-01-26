<?php

namespace Example\UserContext\Model;

use Directory;
use Example\Model\Specification;
use Example\Model\ValueObject;

class PasswordIsNotBlockedSpecification implements Specification
{
    /**
     * @var Directory
     */
    private $fileLocation;

    /**
     * @var string
     */
    private $blockedPasswordsFileName;

    /**
     * @param Directory $fileLocation
     * @param string    $blockedPasswordsFileName
     */
    public function __construct(Directory $fileLocation, string $blockedPasswordsFileName)
    {
        $this->fileLocation = $fileLocation;
        $this->blockedPasswordsFileName = $blockedPasswordsFileName;
    }

    /**
     * @param  ValueObject $valueObject
     * @return bool
     */
    public function isSatisfiedBy(ValueObject $valueObject): bool
    {
        return $this->testPasswordAgainstFileContents((string) $valueObject);
    }

    /**
     * @param  string $password
     * @return bool
     */
    private function testPasswordAgainstFileContents(string $password): bool
    {
        $filename = implode('/', [
            $this->fileLocation->path,
            $this->blockedPasswordsFileName
        ]);
        $returnValue = true;

        if ($file = fopen($filename, 'r')) {
            while (!feof($file)) {
                $line = trim(fgets($file));

                if ($line === $password) {
                    $returnValue = false;
                    break;
                }
            }

            fclose($file);
        }

        return $returnValue;
    }
}
