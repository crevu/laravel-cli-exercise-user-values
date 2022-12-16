<?php

namespace App\Models;

/**
 * class User
 *
 * @package App\Models
 */
class User extends Model
{
    private string $email;

    /**
     * @param string $_id
     * @param string $email
     */
    public function __construct(string $_id, string $email)
    {
        parent::__construct($_id);

        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
