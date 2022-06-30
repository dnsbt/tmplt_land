<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $title
 * @property-read string $description
 * @property-read int $file_id
 */
class ClientMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
            'email' => 'required|string|min:6',
            'phone' => 'required|numeric|min:9',
            'message' => 'required|string|min:5'
        ];
    }
}
