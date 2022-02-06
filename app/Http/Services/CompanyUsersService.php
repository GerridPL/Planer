<?php

namespace App\Http\Services;

use App\Models\User;

class CompanyUsersService
{
    public static function getUserById($userId, $authorizedUser)
    {
        $showUser = User::where('company', $authorizedUser->company)
            ->withTrashed()
            ->findOrFail($userId);
        return $showUser;
    }
}
