<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupRequest extends FormRequest {

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
            'group_status' => 'required'
        ];

        //Them moi
        $this->_method_post($rules);
        $this->_method_put($rules);
        $this->_method_delete($rules);

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
            $rule_tmp['group_name'] = 'required|unique:cores_groups';
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
                'id' => 'exists:cores_groups,group_id,' . request()->id,
                'group_name' => [
                    'required',
                    Rule::unique('cores_groups', 'group_name')->ignore(request()->id, 'group_id'),
                ],
            ];
        }
        $rules = array_merge($rules, $rule_tmp);
    }

    private function _method_delete(array &$rules = [])
    {
        if (request()->method == 'DELETE')
        {
            $rules = ['id' => 'exists:cores_groups,group_id,' . request()->id];
        }
    }

}
