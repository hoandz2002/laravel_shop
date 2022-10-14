<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'orderName'=> 'required',
            'oderEmail'=> 'required|email',
            'phone'=> 'required|numeric',
            'address'=> 'required'
        ];
    }
    public function messages()
    {
        return [
            'orderName.required' => 'Tên không được để trống!',
            'oderEmail.required' => 'Email không được để trống!',
            'oderEmail.email' => 'Email phải đúng định dạng!',
            'phone.required' => 'Số điện thoại không được để trống!',
            'phone.numeric' => 'Số điện thoại phải là số!',
            'address.required' => 'Địa chỉ không được để trống!',
        ];
    }
}
