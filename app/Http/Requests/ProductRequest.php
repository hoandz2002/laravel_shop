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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                'nameProduct'=> 'required|min:6',
                // 'price' => 'required|integer',
                'description' => 'required|max:3000',
                'category_id' => 'required',
                // 'size_id1' => 'required',
                // 'size_id2' => 'required',
                // 'size_id3' => 'required'

        ];
    }
    public function messages() {
        return [
            'nameProduct.required' => 'Tên sản phẩm không được để trống',
            'nameProduct.min' => 'Tên sản phẩm tối thiểu 6 kí tự',
            // 'price.required' => 'Giá sản phẩm không được để trống',
            // 'price.integer' => 'Giá sản phẩm phải là số dương',
            'description.required' => 'Tiêu đề sản phẩm không được để trống',
            'description.max' => 'Mô tả sản phẩm không được quá 3000 kí tự',
            // 'size_id1.required' => 'Kích cỡ sản phẩm không được để trống',
            // 'size_id2.required' => 'Kích cỡ sản phẩm không được để trống',
            // 'size_id3.required' => 'Kích cỡ sản phẩm không được để trống',
            'category_id.required' => 'Danh mục sản phẩm không được để trống',

        ];
    }
}
