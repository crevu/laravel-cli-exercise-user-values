<?php

namespace App\Services;

use App\Exceptions\FailedValidationException;

/**
 * class ValidationService
 *
 * @package App\Services
 */
class ValidationService
{
    /**
     * @param string $filePath
     *
     * @return void
     *
     * @throws FailedValidationException
     */
    public function validateFileExists(string $filePath): void
    {
        try {
            $fileStream = fopen($filePath, "r");

            fclose($fileStream);
        } catch (\Exception $exception) {
            throw new FailedValidationException(
                sprintf(FailedValidationException::MSG_INVALID_FILE_PATH, $filePath)
            );
        }
    }
}
