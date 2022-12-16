<?php

namespace App\Services\Searchers;

use App\Models\Model;

/**
 *
 */
interface LocalizedSearchInterface
{
    /**
     * @param string $languageCode
     * @param string $localizedValue
     *
     * @return Model|null
     */
    public function searchByLocalizedValue(string $languageCode, string $localizedValue): ?Model;
}
