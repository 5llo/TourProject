<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSerivceRequest extends FormRequest
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
            'name' => ['required', 'string','max:20','min:4'],
            'type' => ['string', 'required','max:10','min:4','in:restaurant,hotel,chalet,vehicle'],
            'location' => ['array', 'present','size:1'],
            'location.*.latitude' => ['required','numeric'],
            'location.*.longitude' => ['required','numeric'],
            'service_content'=>['array','present'],
            'service_content.*.name' => ['required','string'],
            'service_content.*.price' => ['required','numeric'],
            'image'=>['required','image','mimes:jpeg,png,jpg,gif','max:2048'],
        ];
    }
}
