<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientAddressStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'city' => 'required|string|max:255',
            'subcity' => 'required|string|max:255',
            'kebele' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:13|min:10',
            'email' => 'required|string|email|max:255'
        ];
    }
}
