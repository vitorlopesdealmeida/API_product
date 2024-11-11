<?php

namespace Modules\Product\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Product\App\Models\Product;
use Modules\Product\App\Repositories\ProductRepository;
use Modules\Product\App\Resources\ProductResource;
use Modules\Product\App\Http\Requests\StoreProductRequest;
use Modules\Product\App\Http\Requests\UpdateProductRequest;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'name',
            'status',
        ]);
        $products = Product::filter($filters)->paginate(20)->withQueryString();
        $response = $this->makeResponsePaginate(ProductResource::collection($products));
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * Show the specified resource.
     *
     * @param \Modules\Product\App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Modules\Product\App\Http\Requests\UpdateProductRequest  $request
     * @param \Modules\Product\App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json(new ProductResource($product), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Modules\Product\App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        Product::destroy($product->id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
