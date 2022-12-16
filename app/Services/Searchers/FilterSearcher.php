<?php

namespace App\Services\Searchers;

use App\Models\Filter;
use App\Models\Model;

/**
 * class FilterSearch
 *
 * @package App\Services\Searchers
 */
class FilterSearcher implements LocalizedSearchInterface
{
    /** @var Filter[] $filters */
    private array $filters;

    /**
     * @param Filter[] $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @param string $languageCode
     * @param string $localizedValue
     *
     * @return Model|null
     */
    public function searchByLocalizedValue(string $languageCode, string $localizedValue): ?Model
    {
        foreach ($this->filters as $filter) {
            foreach ($filter->getNames() as $localizedName) {
                if (
                    $localizedName->getLanguage() === $languageCode
                    && $localizedName->getValue() === $localizedValue
                ) {
                    return $filter;
                }
            }
        }

        return null;
    }
}
