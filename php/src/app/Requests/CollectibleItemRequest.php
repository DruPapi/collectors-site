<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read ?int $category_id
 * @property-read ?string $order_by
 * @property-read ?string $order_direction asc|desc
 */
class CollectibleItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'order_by' => ['nullable'],
            'order_direction' => ['nullable', 'in:asc,desc'],
        ];
    }
}
