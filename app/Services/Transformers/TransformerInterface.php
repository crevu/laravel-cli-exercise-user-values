<?php

namespace App\Services\Transformers;

use App\Exceptions\FailedValidationException;

/**
 * interface TransformerInterface
 *
 * @package App\Services\Transformers
 */
interface TransformerInterface
{
    /**
     * @param string $languageCode
     * @param array  $csvData
     *
     * @return array
     */
    public function transform(string $languageCode, array $csvData): array;
}
