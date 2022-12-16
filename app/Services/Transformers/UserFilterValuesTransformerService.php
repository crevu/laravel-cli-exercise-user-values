<?php

namespace App\Services\Transformers;

use App\Exceptions\FailedValidationException;
use App\Models\Filter;
use App\Models\UserFilterValues;
use App\Services\Loaders\FilterLoader;
use App\Services\Loaders\UserLoader;
use App\Services\Searchers\FilterSearcher;
use App\Services\Searchers\FilterValueSearcher;
use App\Services\Searchers\UserSearcher;

/**
 * class UserFilterValuesTransformerService
 *
 * @package App\Services\Transformers
 */
class UserFilterValuesTransformerService implements TransformerInterface
{
    private UserSearcher $userSearcher;

    private FilterSearcher $filterSearcher;

    /**
     * @param UserLoader   $userLoader
     * @param FilterLoader $filterLoader
     *
     * @throws FailedValidationException
     */
    public function __construct(UserLoader $userLoader, FilterLoader $filterLoader)
    {
        $this->userSearcher   = new UserSearcher($userLoader->load());
        $this->filterSearcher = new FilterSearcher($filterLoader->load());
    }

    /**
     * @param string $languageCode
     * @param array  $csvData
     *
     * @return array
     */
    public function transform(string $languageCode, array $csvData): array
    {
        $result = [];

        foreach ($csvData as $csvUserEmail => $csvUserFilters) {
            $user    = $this->userSearcher->searchByEmail($csvUserEmail);
            $filterValues = [];

            if ($user === null) {
                //TODO: add a logging service that saves all csv Users that are not found
                continue;
            }

            foreach ($csvUserFilters as $csvFilterName => $csvFilterValue) {
                /** @var Filter $filter */
                $filter = $this->filterSearcher->searchByLocalizedValue($languageCode, $csvFilterName);

                if ($filter === null) {
                    //TODO: add a logging service that saves all csv Filters that are not found
                    continue;
                }

                $filterValueSearcher = new FilterValueSearcher($filter->getFilterValues());
                $filterValue         = $filterValueSearcher->searchByLocalizedValue($languageCode, $csvFilterValue);

                if ($filterValue === null) {
                    //TODO: add a logging service that saves all csv Filter Values that are not found
                    continue;
                }

                $filterValues[] = $filterValue->getId();
            }

            $result[] = new UserFilterValues($user->getId(), $filterValues);
        }

        return $result;
    }
}
