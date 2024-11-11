<?php

namespace Modules\Product\Tests\Unit;

use Modules\Product\App\Http\Controllers\ProductController;
use Modules\Product\App\Http\Requests\StoreProductRequest;
use Modules\Product\App\Http\Requests\UpdateProductRequest;
use Modules\Product\App\Models\Product;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

use Modules\Product\App\Resources\ProductResource;
use Tests\TestCase;
use Mockery;

class ProductControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        restore_error_handler();
        restore_exception_handler();
    }

    public function test_store_product()
    {
        $data = [
            'name' => 'Produto Teste',
            'description' => 'Descrição do produto teste',
            'price' => 100.12,
            'status' => 'em falta',
            'stock_quantity' => 10,
        ];
        $response_data = [
            'name' => 'Produto Teste',
            'description' => 'Descrição do produto teste',
            'price' => 100.12,
        ];

        $requestMock = Mockery::mock(StoreProductRequest::class);
        $requestMock->shouldReceive('validated')->andReturn($data);

        $controller = new ProductController();
        $response = $controller->store($requestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->status());
        $this->assertEquals($response_data, $response->getData(true));
    }

    public function test_update_product_not_found()
    {
        $productId = 999999999;
        $data = ['name' => 'Produto Atualizado'];

        $response = $this->putJson("/products/{$productId}", $data);

        $response->assertStatus(404);
    }

    public function test_update_product()
    {
        $product = Product::factory()->create();
        $update_data = [
            'name' => 'Produto Atualizado',
            'price' => 150.75,
        ];

        $response_data = [
            'name' => 'Produto Atualizado',
            'price' => 150.75,
            'description' => $product->description,
        ];

        $requestMock = Mockery::mock(UpdateProductRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($update_data);

        $controller = new ProductController();
        $response = $controller->update($requestMock, $product);

        $this->assertEquals(200, $response->status());
        $this->assertEquals($response_data, $response->getData(true));
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $controller = new ProductController();
        $response = $controller->destroy($product);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->status());

        $this->assertDatabaseMissing('products', [null]);
    }

}
