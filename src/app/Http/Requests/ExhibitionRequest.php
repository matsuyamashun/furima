<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name'=>'required|max:255',
            'description'=>'required|max:255',
            'image'=>'required|mimes:jpeg,png',
            'categories'=>'required|array|min:1',
            'condition'=>'required',
            'price'=>'required|numeric|gte:0',
        ];
    }

    public function messages()
    {
        return [
        'name.required'=>'商品名を入力してください',
        'name.max'=>'255字以内で入力してください',
        'description.required'=>'商品の説明を入力してください',
        'description.max'=>'255字以内で入力してください',
        'image.required'=>'アップロード必須です',
        'image.mimes'=>'画像は.拡張子が.jpegもしくは.png形式でお願いします',
        'categories.required'=>'商品のカテゴリーを選択してください',
        'condition.required'=>'商品の状態を選択してください',
        'price.required'=>'商品の価格を入力してください',
        'price.numeric'=>'価格は数値型で入力してください',
        'price.gte'=>'0円以上で価格を設定してください',
        ];
    }
}
