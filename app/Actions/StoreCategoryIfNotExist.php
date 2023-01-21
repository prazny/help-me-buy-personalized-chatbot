<?php

namespace App\Actions;

use App\Models\ProductCategory;

class StoreCategoryIfNotExist
{
    public function execute(string $category_name): ProductCategory
    {
        $category = ProductCategory::where('name', $category_name)->first();
        if (!$category) {
            $category = ProductCategory::create([
                'name' => $category_name,
            ]);
        }

        return $category;

    }

}
