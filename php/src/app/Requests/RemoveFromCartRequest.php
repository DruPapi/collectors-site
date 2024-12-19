<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveFromCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'collectible_id' => 'required|exists:collectibles,id',
        ];
    }
}
