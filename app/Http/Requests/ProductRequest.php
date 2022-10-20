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
        $data = $this->all();
        return [
            'nameProduct' => 'required|min:6',
            'price_in_active' => 'required|integer',
            'description' => 'required|max:3000',
            'category_id' => 'required',
            'material_Id' => [
                function ($attribute, $value, $fail) use ($data) {
                    $count = count($value);
                    foreach ($value as $key => $item) {
                        for ($i = 0; $i < $count; $i++) {
                            if ($i == $key) {
                                continue;
                            }
                            // dd($value[$i]);
                            if ($item == $value[$i]) {
                                if ($data['size_Id'][$i] == $data['size_Id'][$key]) {
                                    return $fail('Không được nhập trùng size trong cùng 1 chất liệu');
                                }
                            }
                        }
                        // if($item>1){
                        //     return $fail('khong duoc nhap trung size trong chat lieu');
                        // }
                    }
                }
            ],
            'price' => [
                function ($attribute, $value, $fail) {
                    foreach ($value as $key => $item) {
                       if ($item == null) {
                        return $fail('không được để trống giá tiền !');
                       }
                    }
                  
                }
            ]

        ];
    }
    public function messages()
    {
        return [
            'nameProduct.required' => 'Tên sản phẩm không được để trống',
            'nameProduct.min' => 'Tên sản phẩm tối thiểu 6 kí tự',
            'description.required' => 'Tiêu đề sản phẩm không được để trống',
            'description.max' => 'Mô tả sản phẩm không được quá 3000 kí tự',
            'category_id.required' => 'Danh mục sản phẩm không được để trống',
            'price_in_active.required' => 'Không được để trống giá hiển thị',
            'price_in_active.integer' => 'bạn nhập sai định dạng giá tiền',

        ];
    }
}
