<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeStore extends FormRequest
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
                'first_name'=>'required', 
                'middle_name'=>'required', 
                'last_name'=>'required',  
                'id_number'=>'required',  
                'factory'=>'required',  
                'department'=>'required',  
                'section'=>'required',  
                'position'=>'required', 
        ];
    }
    protected function failedValidation(Validator $validator) 
    { 
        throw new HttpResponseException(response()->json(['response'=>'error','message'=>'Validation failed!','data'=>$validator->errors()], 422)); 
    }
}
