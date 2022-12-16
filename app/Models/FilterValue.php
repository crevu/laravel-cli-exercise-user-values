<?php

namespace App\Models;

/**
 * class FilterValue
 *
 * @package App\Models
 */
class FilterValue extends Model
{
    /** @var LocalizedValue[] */
    private array $localizedValues;

    /**
     * @param string $_id
     * @param array  $localizedValues
     */
    public function __construct(string $_id, array $localizedValues)
    {
        parent::__construct($_id);

        $this->localizedValues = $localizedValues;
    }

    /**
     * @return LocalizedValue[]
     */
    public function getLocalizedValues(): array
    {
        return $this->localizedValues;
    }
}
