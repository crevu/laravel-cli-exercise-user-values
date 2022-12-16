<?php

namespace App\Models;

/**
 * Class Model - abstract
 *
 * @package App\Models
 */
abstract class Model
{
    protected string $_id;

    /**
     * @param string $_id
     */
    public function __construct(string $_id)
    {
        $this->_id = $_id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->_id;
    }
}
