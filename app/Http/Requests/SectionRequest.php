<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
        switch(request()->method){
            case 'POST':
                return [
                    'section_name' => 'required|string|min:3|max:255|unique:sections,section_name',
                    'description' => "nullable|min:3|max:500",
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'section_name' => 'required|string|min:3|max:255|unique:sections,section_name,'.$this->id,
                    'description' => "nullable|min:3|max:500",
                ];
        }
    }

    public function messages()
    {
        return [
            'section_name.required' => 'اسم القسم مطلوب',
            'section_name.string' => 'اسم القسم يجب ان يكون حروف',
            'section_name.min' => 'اسم القسم يجب الا يقل عن 3 حروف',
            'section_name.max' => 'اسم القسم يجب الا يزيد عن 255 حرف',
            'section_name.unique' => 'اسم القسم موجود',
            'description.min' => 'وصف القسم يجب الا يقل عن 3 حروف',
            'description.max' => 'وصف القسم يجب الا يزيد عن 255 حرف',
        ];
    }
}
