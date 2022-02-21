<?php

namespace App\Http\Requests;

use App\Rules\Name;
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
            'email' => 'required|email',
            'phone' => 'required|regex:#^\+?[0-9 \-]+$#',
            'address' => 'required',
            'address.name' => ['required', new Name()],
            'address.line1' => 'required',
            'address.city' => 'required',
            // a sample requirement for a Latvian postcode
            'address.postcode' => 'required|regex:#lv-[0-9]{4}#i',
            'address.country' => 'required|in:LV,UA',
            'items' => 'required|array',
            'items.*.sku' => 'required|integer',
        ];
    }

    protected function prepareForValidation()
    {
        $address = $this->input('address');

        foreach (['line1', 'line2', 'city'] as $field) {
            $address[$field] = filter_var($address[$field], FILTER_SANITIZE_STRING);
        }

        // filter unvalidated fields
        $this->merge([
            'address' => $address,
        ]);
    }
}
