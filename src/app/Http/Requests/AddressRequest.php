<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'postal_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|max:50',
        ];
    }

    public function messages():array
    {
        return[
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号はハイフンありの8文字（半角）で入力してください',
            'address.required' => '住所を入力してください', 
            'address.max' => '住所は50文字以内で入力してください',
        ];
    }
}
