<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Illuminate\Validation\Validator;
use App\Http\Controllers\Controller;

class RestController extends Controller
{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    function extendValidator()
    {
        \Validator::extend('not_exists', function($attribute, $value, $parameters)
        {
            return \DB::table($parameters[0])
                            ->where($parameters[1], '=', $value)
                            ->count() < 1;
        });
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(&$validator, array $errors = array())
    {
        $validator->after(function ($validator) use ($errors)
        {
            foreach ($errors as $key => $val)
            {
                $validator->errors()->add($key, $val);
            }
        });
    }

    /**
     * Ham đóng gói lỗi trước khi trả về client
     * @param string $message
     * @param any||null $errorsDetails Thông tin chi tiết lỗi nếu có
     * @param int $httpStatus
     * @param array $header
     * @return type
     */
    function response($message = 'system error', $errorsDetails = null, $httpStatus = 500, array $header = [], $options = 0)
    {
        $errors = ['message' => strval($message)];
        if (!is_null($errorsDetails))
        {
            $errors['errors'] = $errorsDetails;
        }
        return response()->json($errors, $httpStatus, $header, $options);
    }

}
