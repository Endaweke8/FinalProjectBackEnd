<?php

namespace App\Http\Requests\Stock;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'name'=>'required|string|min:3|max:100',
            'slug'=>'required|string|min:3|max:100',
            'description' => 'required|string|min:1',
            'amount' => 'required|string|min:1',
            'sale_price'=> 'required|string|min:1',
           
        ];
    }
}
