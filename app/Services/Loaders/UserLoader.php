<?php

namespace App\Services\Loaders;

use App\Exceptions\FailedValidationException;
use App\Models\User;

/**
 * class UserLoader
 *
 * @package App\Services\Loaders
 */
class UserLoader implements LoaderInterface
{
    const LOAD_FILE = "emails.json";

    const JSON_KEY_ID    = "_id";
    const JSON_KEY_EMAIL = "email";

    /**
     * @return User[]
     *
     * @throws FailedValidationException
     */
    public function load(): array
    {
        $result = [];

        $fullPathToFile = config('constants.load_path') . self::LOAD_FILE;
        $jsonString     = file_get_contents($fullPathToFile);
        $jsonArray      = json_decode($jsonString, true);

        if (empty($jsonArray)) {
            throw new FailedValidationException(sprintf(
                FailedValidationException::MSG_INVALID_JSON,
                $fullPathToFile
            ));
        }

        foreach ($jsonArray as $userData) {
            $result[] = new User($userData[self::JSON_KEY_ID], $userData[self::JSON_KEY_EMAIL]);
        }

        return $result;
    }
}
