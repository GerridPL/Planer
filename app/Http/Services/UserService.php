<?php

namespace App\Http\Services;

use App\Models\User;

class UserService
{
    public static function ifUserIsCompanyUser($userAuthenticated, $userId)
    {
        $companyUser = User::with('user_company_relation')
            ->where('company', $userAuthenticated->company)
            ->findOrFail($userId);
        return $companyUser;
    }

    public static function getUsersFromCompanyByUser($user)
    {
        $users = User::with('user_company_relation')->where('company', $user->company)->get();
        return $users;
    }
}
