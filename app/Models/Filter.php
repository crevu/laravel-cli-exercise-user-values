<?php

namespace App\Models;

/**
 * class Filter
 *
 * @package App\Models
 */
class Filter extends Model
{
    /** @var LocalizedValue[]  */
    private array $names;

    /** @var FilterValue[] */
    private array $filterValues;

    /**
     * @param string           $_id
     * @param LocalizedValue[] $names
     * @param FilterValue[]    $filterValues
     */
    public function __construct(string $_id, array $names, array $filterValues)
    {
        parent::__construct($_id);

        $this->names         = $names;
        $this->filterValues = $filterValues;
    }

    /**
     * @return LocalizedValue[]
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * @return FilterValue[]
     */
    public function getFilterValues(): array
    {
        return $this->filterValues;
    }
}
