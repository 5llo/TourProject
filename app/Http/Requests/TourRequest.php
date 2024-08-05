<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
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

            'path' => 'required|array|min:2',
            'path.*.latitude' => 'required|numeric',
            'path.*.longitude' => 'required|numeric',
            'quantity' => 'required|integer|min:20|max:40',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'description' => 'required|string',
            'status' => 'required|in:active,terminated,pending,rejected',
            'price' => 'required|numeric',
            'services' => 'required|array|min:1',
            'services.*.id' => 'required|integer|exists:services,id',
            'services.*.service_type' => 'required|string',
            'services.*.date_appointment' => 'required|date|after:date_start',
            'services.*.service_contents_ids' => 'required|array|min:1',
            'services.*.service_contents_ids.*' => 'required|integer|exists:service_contents,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
