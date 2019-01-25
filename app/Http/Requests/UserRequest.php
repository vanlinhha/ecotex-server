<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest {

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
        $rules = [
            'user_name' => 'required|string|max:50',
            'user_phone' => 'required|numeric',
            'user_address' => 'required',
            'user_order' => 'required|numeric'
        ];

        //Them moi
        $this->_method_post($rules);
        $this->_method_put($rules);

        return $rules;
    }
    
    /**
     * validator insert
     * @param array $rules
     */
    private function _method_post(array &$rules = [])
    {
        $rule_tmp = [];
        if (request()->method == 'POST')
        {
            $rule_tmp = [
                'user_login_name' => 'required|string|max:50|unique:users',
                'user_password' => 'required|min:6|confirmed',
                'user_email' => 'required|email|unique:users',
            ];
        }

        $rules = array_merge($rules, $rule_tmp);
    }

    /**
     * validator edit user
     * @param array $rules
     */
    private function _method_put(array &$rules = [])
    {
        $rule_tmp = [];
        if (request()->method == 'PUT')
        {
            $rule_tmp = [
                'id' => 'exists:users,id,' . request()->id,
                'user_login_name' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('users', 'user_login_name')->ignore(request()->id,'id')
                ],
                'user_email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'user_email')->ignore( request()->id,'id')
                ],
            ];
            if (trim(request()->input('user_password')))
            {
                $rule_tmp['user_password'] = 'required|min:6|confirmed';
            }
        }
        $rules = array_merge($rules, $rule_tmp);
    }

}
