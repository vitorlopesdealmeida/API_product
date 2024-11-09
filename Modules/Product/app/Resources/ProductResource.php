<?php

namespace Modules\Product\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            // 'status' => $this->status,
            'price' => $this->price,
            // 'stock_quantity' => $this->stock_quantity,
            // 'stock_value' => $this->stock_quantity * $this->price,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
