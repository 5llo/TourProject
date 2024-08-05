<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSerivceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'=>['required','integer','exists:services,id'],
            'name' => ['required', 'string','max:20','min:4'],
            'service_content'=>['array','present'],
            'service_content.*.name' => ['required','string'],
            'service_content.*.price' => ['required','numeric'],
        ];
    }
}
