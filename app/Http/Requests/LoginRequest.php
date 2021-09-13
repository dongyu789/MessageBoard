<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            //不得为空，用户和密码的长度都在6-8个字符,用户和密码只能填写字母数字下划线
            'username' => 'required | min:1 | max:20 | alpha_dash | exists:users,user_id',
            'pwd' => 'required | min:6 | max:20 | alpha_dash'
        ];

    }

    public function messages()
    {
        return [
            'username.exists' => "用户名不存在或已注销",
            'username.required'=> "用户名不得为空",
            'username.min' => '用户名不得小于1个字符',
            'username.max' => '用户名不得大于20个字符',
            'username.alpha_dash' => '用户名只能写字母数字下划线',
            'pwd.required'=> "密码不得为空",
            'pwd.min' => '密码不得小于6个字符',
            'pwd.max' => '密码不得大于20个字符',
            'pwd.alpha_dash' => '密码只能写字母数字下划线',
        ];
    }
}
