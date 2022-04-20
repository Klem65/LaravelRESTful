<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

class ProductHelper
{
    /**
     * @param array $params
     * @return Collection
     */
    public static function getProduct(array $params): Collection
    {
        $productQuery = Product::query();

        foreach ($params as $key => $param) {
            if ($key === 'priceStart' || $key === 'priceEnd') {
                $operator = ($key === 'priceStart') ? '>=' : '<=';
                $productQuery->where('price', $operator, $param);
                continue;
            } else if ($key === 'categoryName') {
                $category = Category::all()->where('name', '=', $param)->first();
                $listProductCategories = ProductCategory::query()->where('category_id', '=', $category->id);
                $productIds = $listProductCategories->pluck('product_id');
                $productQuery->whereIn('id', $productIds);
                continue;
            }

            $productQuery->where($key, '=', $param);
        }

        return $productQuery->get();
    }

    /**
     * @param int $id
     * @return array
     */
    public static function getProductById(int $id): array
    {
        $product = Product::query()->where('id', '=', $id)->first();
        if (!$product) {
            return ['status' => false];
        }

        return ['status' => true, 'data' => $product];
    }

    /**
     * @param array $params
     * @param array $categories
     * @return bool
     */
    public static function createProduct(array $params, array $categories): bool
    {
        $product = new Product();

        foreach ($params as $key => $param) {
            if ($key === 'categories') {
                continue;
            }

            $product->{$key} = $param;
        }

        $product->save();

        foreach ($categories as $category) {
            $productCategory = new ProductCategory();
            $productCategory->product_id = $product->id;
            $productCategory->category_id = $category;
            $productCategory->save();
        }

        return true;
    }

    /**
     * @param array $params
     * @param int $id
     * @return bool
     */
    public static function updateProduct(array $params, int $id): bool
    {
        $product = Product::query()->where('id', '=', $id)->first();

        if (!$product) {
            return false;
        }

        foreach ($params as $key => $param) {
            $product->{$key} = $param;
        }

        $product->save();

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function deleteProduct(int $id): bool
    {
        $product = Product::query()->where('id', '=', $id)->first();

        if (!$product) {
            return false;
        }

        $product->deleted = 1;
        $product->save();

        return true;
    }
}
