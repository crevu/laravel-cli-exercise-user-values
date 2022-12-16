<?php

namespace App\Models;

/**
 * class LocalizedValue
 *
 * @package App\Models
 */
class LocalizedValue
{
    private string $language;

    private string $value;

    /**
     * @param string $language
     * @param string $value
     */
    public function __construct(string $language, string $value)
    {
        $this->language = $language;
        $this->value    = $value;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
