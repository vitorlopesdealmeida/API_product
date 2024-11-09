<?php

namespace Modules\Product\App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Modules\Product\App\Models\Product;

class ProductRepository
{
    public function findOrFail($id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new ModelNotFoundException(
                response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.',
                ], Response::HTTP_NOT_FOUND)
            );
        }

        return $product;
    }
}
