<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read ?string $order_by
 * @property-read ?string $order_direction asc|desc
 * @property-read ?int $page
 */
class CollectibleListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_by' => ['nullable'],
            'order_direction' => ['nullable', 'in:asc,desc'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
