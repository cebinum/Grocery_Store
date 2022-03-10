<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * Get a list of all publised candidate profiles
     * @return Collection
     */
    public function admins()
    {
        return User::where('role', User::ADMIN)
            ->get();
    }
}
