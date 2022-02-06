<?php

namespace App\Http\Services;

use App\Models\Category;

class CategoryService
{
    public static function getCategoriesFromUser($user)
    {
        $categories = Category::with('company')
            ->where('company', $user->company)
            ->get();
        return $categories;
    }

    public static function getCategoryById($categoryId, $user)
    {
        $category = Category::with('company')
            ->where('company', $user->company)
            ->findOrFail($categoryId);
        return $category;
    }

    public static function getCategoriesWithoutDeactivated($user)
    {
        $categories = Category::with('company')
            ->where('company', $user->company)
            ->where('deactivated', false)
            ->get();

        return $categories;
    }
}
