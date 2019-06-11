<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MultipleEmployeeStoreJSON extends FormRequest
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
            'employees'=>'required|json'
        ];
    }

    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            dd($validator->getValue('employees'));
            return response()->json($validator);
            
        });
    }
}
