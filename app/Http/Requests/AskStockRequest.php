<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AskStockRequest extends FormRequest
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
            'firstName' => 'required|string',
            'lastName' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            
            'amount' => 'required|string|max:255',
            'buying_price' => 'required|string|max:255',
            'stockType' => 'required|string|max:255',
        ];
    }
}
