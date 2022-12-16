<?php

namespace App\Services\Loaders;

use App\Exceptions\FailedValidationException;

/**
 * interface LoaderInterface
 */
interface LoaderInterface
{
    /**
     * @return array
     * @throws FailedValidationException
     */
    public function load(): array;
}
