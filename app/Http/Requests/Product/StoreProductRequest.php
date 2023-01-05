<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
   

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
            'price'=> 'required|string|min:1',
            'sale_price'=> 'required|string|min:1',
           
        ];
    }
}
