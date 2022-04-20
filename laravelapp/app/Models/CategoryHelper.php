<?php

namespace App\Models;

class CategoryHelper
{
    /**
     * @param array $params
     * @return bool
     */
    public static function createCategory(array $params): bool
    {
        $category = new Category();

        foreach ($params as $key => $param) {
            $category->{$key} = $param;
        }
        $category->save();

        return true;
    }

    /**
     * @param int $id
     * @return array
     */
    public static function deleteCategory(int $id): array
    {
        $category = Category::query()->where('id', '=', $id)->first();

        if (!$category) {
            return ['status' => false, 'message' => 'Category with ID: ' . $id . ' not found'];
        }

        $listProductCategories = ProductCategory::query()->where('category_id', '=', $category->id)->get();

        if ($listProductCategories->count() !== 0) {
            return ['status' => false, 'message' => 'Category not deleted. Category have product'];
        }

        $category->deleted = 1;
        $category->save();

        return ['status' => true];
    }
}
