<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePasswordRequest extends FormRequest
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
        $rules = [
            'user_login_name' => 'required|string|max:50|exists:users,user_login_name',
            'password_old'    => 'required',
            'password'        => 'required|confirmed',
        ];
        //Them moi
        $this->_method_post($rules);
        $this->_method_put($rules);
        $this->_method_delete($rules);
        return $rules;
    }

    private function _method_post(array &$rules = [])
    {
        $rulePost = [];
        if (request()->method == 'POST')
        {
            $rulePost = [];
        }
        $rules = array_merge($rulePost, $rules);
    }

    private function _method_put(array &$rules = [])
    {
        $rulePut = [];
        if (request()->method == 'PUT')
        {
            $rulePut = [];
        }
        $rules = array_merge($rulePut, $rules);
    }

    private function _method_delete(array &$rules = [])
    {
        if (request()->method == 'DELETE')
        {
            $rules = [];
        }
    }

}
