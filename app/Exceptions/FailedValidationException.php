<?php

namespace App\Exceptions;

use Exception;

/**
 * Class FailedValidationException
 *
 * @package App\Exceptions
 */
class FailedValidationException extends Exception
{
    const MSG_INVALID_FILE_PATH = 'Could not open file %s. Make sure file exists and you have read permission.';
    const MSG_INVALID_JSON = 'Could not load json file %s. Make sure file exists it is valid json.';
}
