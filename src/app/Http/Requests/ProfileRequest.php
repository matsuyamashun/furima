<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'avatar' =>'nullable|mimes:jpeg,png|max:51200',
            'username'=>'required|string|max:20',
            'postal_code'=>'required|string',
            'address'=>'required|string',
            'bilding'=>'nullable|string',
        ];
    }

    public function messages()
    {
        return[
        'avatar.image'=>'プロフィール画像は.拡張子が.jpegもしくは.png形式でお願いします',
        'avatar.max'=>'50MBまでのファイルでよろしくお願いします',
        'username.required'=>'ユーザー名を入力してください',
        'username.max'=>'ユーザー名は20文字以内で入力してください',
        'postal_code.required'=>'郵便番号を入力してください',
        'address.required'=>'住所を入力してください',
        ];
    }
}
