<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        $params = $request->all();

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

    public function getProductById($id)
    {
        return Product::query()->where('id', '=', $id)->first();
    }

    public function createProduct(Request $request)
    {
        $params = $request->post();

        $product = new Product();
        foreach ($params as $key => $param) {

            if ($key === 'categories') {
                $categories = explode(',', $params['categories']);
                if (count($categories) >= 2 and count($categories) <= 10) {
                    foreach ($categories as $category) {
                        $productCategory = new ProductCategory();
                        $productCategory->product_id = $product->id;
                        $productCategory->category_id = $category;
                        $productCategory->save();
                    }
                } else {
                    return response('A product can have from 2 to 10 categories', 405);
                }
            }

            $product->{$key} = $param;
        }

        $product->save();

        return response('Product create', 200);
    }

    public function updateProduct(Request $request, $id)
    {
        $params = $request->all();

        $product = Product::query()->where('id', '=', $id)->first();
        foreach ($params as $key => $param) {
            $product->{$key} = $param;
        }

        $product->save();

        return response('Product update', 200);
    }

    public function deleteProduct($id)
    {
        $product = Product::query()->where('id', '=', $id)->first();
        $product->deleted = 1;
        $product->save();
        return response('Product deleted', 200);
    }
}
