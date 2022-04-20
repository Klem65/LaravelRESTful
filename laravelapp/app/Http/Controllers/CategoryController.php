<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        $params = $request->post();
        $category = new Category();

        foreach ($params as $key => $param) {
            $category->{$key} = $param;
        }
        $category->save();

        return response('Category create', 200);
    }

    public function deleteCategory($id)
    {
        $category = Category::query()->where('id', '=', $id)->first();

        $listProductCategories = ProductCategory::query()->where('category_id', '=', $category->id);

        if ($listProductCategories->count() === 0) {
            return response('Category not deleted. Category have product', 405);
        }

        $category->deleted = 1;
        $category->save();
        return response('Category deleted', 200);
    }
}
