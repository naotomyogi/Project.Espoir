<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'item-image' => ['required', 'file', 'image'],
            'name'  => ['required','string','max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'category' => ['required', 'integer'],
            'price' => ['required', 'integer', 'min:100', 'max:999999']
        ];
    }

    public function attributes(){
        return [
            'image_file' => '商品画像',
            'name' => '商品名',
            'description' => '商品の説明',
            'category' => 'カテゴリ',
            'price' => '販売価格'
        ];
    }
}
