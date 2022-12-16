<?php

namespace App\Models;

use JsonSerializable;

/**
 * class UserFilterValues
 *
 * @package App\Models
 */
class UserFilterValues extends Model implements JsonSerializable
{
    /** @var string[] */
    private array $filterValues;

    /**
     * @param string   $_id
     * @param string[] $filterValues
     */
    public function __construct(string $_id, array $filterValues)
    {
        parent::__construct($_id);

        $this->filterValues = $filterValues;
    }

    /**
     * @return string[]
     */
    public function getFilterValues(): array
    {
        return $this->filterValues;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
