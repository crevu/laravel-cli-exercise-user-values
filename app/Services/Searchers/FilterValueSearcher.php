<?php

namespace App\Services\Searchers;

use App\Models\FilterValue;
use App\Models\LocalizedValue;
use App\Models\Model;

/**
 * class FilterValueSearcher
 *
 * @package App\Services\Searchers
 */
class FilterValueSearcher implements LocalizedSearchInterface
{
    /** @var FilterValue[]  */
    private array $filterValues;

    /**
     * @param FilterValue[] $filterValues
     */
    public function __construct(array $filterValues)
    {
        $this->filterValues = $filterValues;
    }

    /**
     * @param string $languageCode
     * @param string $localizedValue
     *
     * @return Model|null
     */
    public function searchByLocalizedValue(string $languageCode, string $localizedValue): ?Model
    {
        foreach ($this->filterValues as $filterValue) {
            foreach ($filterValue->getLocalizedValues() as $localizedFilterValue) {
                if (
                    $localizedFilterValue->getLanguage() === $languageCode
                    && $localizedFilterValue->getValue() === $localizedValue
                ) {
                    return $filterValue;
                }
            }
        }

        return null;
    }
}
