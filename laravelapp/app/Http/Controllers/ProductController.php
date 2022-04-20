<?php

namespace App\Http\Controllers;

use App\Models\ProductHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getProducts(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'priceStart' => 'integer',
            'priceEnd' => 'integer',
            'published' => 'boolean',
            'deleted' => 'boolean',
            'categoryName' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $validateParams = $validator->validate();

        return new JsonResponse(ProductHelper::getProduct($validateParams));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getProductById(int $id): JsonResponse
    {
        $result = ProductHelper::getProductById($id);

        if (!$result['status']) {
            return new JsonResponse('Product with ID: ' . $id . ' not found', 405);
        }

        return new JsonResponse($result['data']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function createProduct(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'published' => 'required|boolean',
            'deleted' => 'required|boolean',
            'categories' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $validateParams = $validator->validate();

        $categories = explode(',', $validateParams['categories']);
        if (!(count($categories) >= 2) || !(count($categories) <= 10)) {
            return new JsonResponse('A product can have from 2 to 10 categories', 405);
        }

        ProductHelper::createProduct($validateParams, $categories);

        return new JsonResponse('Product create', 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateProduct(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'price' => 'regex:/^\d+(\.\d{1,2})?$/',
            'published' => 'boolean',
            'deleted' => 'boolean',
            'categories' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $validateParams = $validator->validate();

       if (!ProductHelper::updateProduct($validateParams, $id)) {
           return new JsonResponse('Product with ID: ' . $id . ' not found', 405);
       }

        return new JsonResponse('Product update', 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteProduct(int $id): JsonResponse
    {
        if (!ProductHelper::deleteProduct($id)) {
            return new JsonResponse('Product with ID: ' . $id . ' not found', 405);
        }

        return new JsonResponse('Product deleted', 200);
    }
}
