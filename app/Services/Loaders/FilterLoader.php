<?php

namespace App\Services\Loaders;

use App\Exceptions\FailedValidationException;
use App\Models\Filter;
use App\Models\FilterValue;
use App\Models\LocalizedValue;

/**
 * class FilterLoader
 *
 * @package App\Services\Loaders
 */
class FilterLoader implements LoaderInterface
{
    const LOAD_FILE       = "filters.json";
    const JSON_KEY_ID     = "_id";
    const JSON_KEY_NAME   = "name";
    const JSON_KEY_VALUES = "values";

    /**
     * @return Filter[]
     *
     * @throws FailedValidationException
     */
    public function load(): array
    {
        $result = [];

        $fullPathToFile = config('constants.load_path') . self::LOAD_FILE;
        $jsonString     = file_get_contents($fullPathToFile);
        $jsonArray      = json_decode($jsonString, true);

        if (empty($jsonArray)) {
            throw new FailedValidationException(sprintf(
                FailedValidationException::MSG_INVALID_JSON,
                $fullPathToFile
            ));
        }

        foreach ($jsonArray as $emailData) {
            $result[] = new Filter(
                $emailData[self::JSON_KEY_ID],
                $this->getNames($emailData[self::JSON_KEY_NAME]),
                $this->getFilterValues($emailData[self::JSON_KEY_VALUES])
            );
        }

        return $result;
    }

    /**
     * @param array $jsonName
     *
     * @return LocalizedValue[]
     */
    private function getNames(array $jsonName): array
    {
        $names = [];

        foreach (config('constants.localizations') as $localization) {
            $names[] = new LocalizedValue($localization, $jsonName[$localization]);
        }

        return $names;
    }

    /**
     * @param array $jsonValues
     *
     * @return FilterValue[]
     */
    private function getFilterValues(array $jsonValues): array
    {
        $filterValues = [];

        foreach ($jsonValues as $jsonValue) {
            $filterValues[] = new FilterValue(
                $jsonValue[self::JSON_KEY_ID],
                $this->getLocalizedFilterValues($jsonValue)
            );
        }

        return $filterValues;
    }

    /**
     * @param array $jsonValue
     *
     * @return LocalizedValue[]
     */
    private function getLocalizedFilterValues(array $jsonValue): array
    {
        $localizedValues = [];

        foreach (config('constants.localizations') as $localization) {
            $localizedValues[] = new LocalizedValue($localization, $jsonValue[$localization]);
        }

        return $localizedValues;
    }
}
