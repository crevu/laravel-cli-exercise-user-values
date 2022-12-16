<?php

namespace App\Services\Searchers;

use App\Models\Model;
use App\Models\User;

/**
 * class UserSearch
 *
 * @package App\Services\Searchers
 */
class UserSearcher
{
    /** @var User[] $users */
    private array $users;

    /**
     * @param User[] $users
     */
    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * @param string $email
     *
     * @return Model|null
     */
    public function searchByEmail(string $email): ?Model
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }

        return null;
    }
}
