<?php

namespace Modules\Product\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Product\App\Models\Product;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'string',
                Rule::unique('products')->ignore($this->route('product'))
            ],
            'description' => ['nullable'],
            'price' => ['nullable', 'numeric'],
            'status' => ['nullable', 'in:' . implode(',', Product::getStatuses())],
            'stock_quantity' => ['nullable', 'integer'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.string' => 'O campo nome deve ser uma string.',
            'name.unique' => 'Já existe um produto com esse nome.',
            'price.numeric' => 'O campo preço deve ser numérico.',
            'status.in' => 'O campo status deve ser: ' . implode(',', Product::getStatuses()) . '.',
            'stock_quantity.integer' => 'O campo quantidade em estoque deve ser um número inteiro.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
