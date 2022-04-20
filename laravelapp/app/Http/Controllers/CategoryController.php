<?php

namespace App\Http\Controllers;

use App\Models\CategoryHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function createCategory(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $validateParams = $validator->validate();

        CategoryHelper::createCategory($validateParams);

        return new JsonResponse('Category create', 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteCategory(int $id): JsonResponse
    {
        $result = CategoryHelper::deleteCategory($id);

        if (!$result['status']) {
            return new JsonResponse($result['message'], 405);
        }

        return new JsonResponse('Category deleted', 200);
    }
}
