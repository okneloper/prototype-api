<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'address.line1' => 'required',
            'address.city' => 'required',
            // a sample requirement for a Latvian postcode
            'address.postcode' => 'required|regex:#lv-[0-9]{4}#i',
            'address.country' => 'required',
            'items' => 'required|array',
            'items.*.sku' => 'required',
        ];
    }
}
