<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => 'required|string|min:3|max:255',
            'description' => "nullable|min:3|max:500",
            'section_id' => 'required|exists:sections,id'
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'اسم المنتج مطلوب',
            'product_name.string' => 'اسم المنتج يجب ان يكون حروف',
            'product_name.min' => 'اسم المنتج يجب الا يقل عن 3 حروف',
            'product_name.max' => 'اسم المنتج يجب الا يزيد عن 255 حرف',
            'description.min' => 'وصف المنتج يجب الا يقل عن 3 حروف',
            'description.max' => 'وصف المنتج يجب الا يزيد عن 255 حرف',
            'section_id.required' => 'برجاء اختيار احد الاقسام',
            'section_id.exists' => 'يجب ان يكون القسم من المتاحين فقط'
        ];
    }
}
