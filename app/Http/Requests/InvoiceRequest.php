<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'invoice_number' => 'required|min:3|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'section_id' => 'required|exists:sections,id',
            'product_id' => 'required|exists:products,id',
            'amount_collection' => 'required|numeric',
            'amount_commission' => 'required|numeric',
            'discount' => 'required|numeric',
            'rate_vat' => 'required|numeric',
            'value_vat' => 'required|numeric',
            'total' => 'required|numeric',
            'note' => 'nullable|min:3|max:500',
            'attachment' => 'nullable|file|mimes:png,jpg,jpeg,pdf'
        ];
    }

    
    // public function messages()
    // {
    //     return [
            
    //     ];
    // }
}
