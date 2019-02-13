<?php

namespace App\Http\Controllers\API;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\RestController;
use App\Models\Users;

class UserController extends RestController
{

    /**
     *
     * @return Response
     *
     * @SWG\Post(
     *      path="/login",
     *      summary="Authenticate user",
     *      tags={"Authenticate"},
     *      description="Authenticate user",
     *      produces={"application/json"},
     *
     *     @SWG\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email",
     *         type="string",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password",
     *         type="string",
     *         required=true
     *     ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful authenticated",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="token",
     *                  type="string"
     *              ),
     *          )
     *      ),
     *     @SWG\Response(
     *          response=404,
     *          description="Invalid credential",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="error",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => __('invalid_credentials')], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => __('could_not_create_token')], 500);
        }
        $user = JWTAuth::user();
        if ($user->roles()->get(['id'])->count()) {
            $roles = $user->roles()->get()[0]['id'];
        } else {
            $roles = 0;
        }
        $user['role_id'] = $roles;

        return response()->json(['success' => true, 'data' => ['token' => $token, 'user' => $user], 'message' => 'Log in successfully'], 201, []);
    }


    /**
     *
     * @return Response
     *
     * @SWG\Post(
     *      path="/sign_up",
     *      summary="Register user",
     *      tags={"Authenticate"},
     *      description="Register user",
     *      produces={"application/json"},
     *
     *     @SWG\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email",
     *         type="string",
     *         required=true,
     *      @SWG\Schema(ref="#/definitions/Users")
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password",
     *         type="string",
     *         required=true,
     *      @SWG\Schema(ref="#/definitions/Users")
     *     ),
     *     @SWG\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="Password confirmation",
     *         type="string",
     *         required=true,
     *      @SWG\Schema(ref="#/definitions/Users")
     *     ),
     *
     *      @SWG\Response(
     *          response=201,
     *          description="successful registered",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="token",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *          )
     *      ),
     *     @SWG\Response(
     *          response=422,
     *          description="Invalid Information",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="error",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'      => 'string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => __($validator->errors()->toJson()), 'success' => false], 422);
        }

//        Mail::send('welcome', ['key' => 'value'], function($message)
//        {
//            $message->to('havanlinh1996@gmail.com.com', 'John Smith')->subject('Welcome!');
//        });

        $user = Users::create([
            'email'           => $request->post('email'),
            'password'        => Hash::make($request->post('password')),
            'first_name'      => $request->post('first_name'),
            'last_name'       => $request->post('last_name'),
            'phone'           => $request->post('phone'),
            'country'         => $request->post('country'),
            'company_name'    => $request->post('company_name'),
            'company_address' => $request->post('company_address'),
            'brief_name'      => $request->post('brief_name'),
            'website'         => $request->post('website'),
        ]);


        $token = JWTAuth::fromUser($user);

        return response()->json(['success' => true, 'data' => ['token' => $token, 'user' => $user], 'message' => "Created user successfully"], 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['success' => false, 'error' => __('user_not_found')], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['success' => false, 'error' => __('token_expired')], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['success' => false, 'error' => __('token_invalid')], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json($user);
    }

    static function makeInstance()
    {
        return new self();
    }

    /**
     * Log out
     *
     * @SWG\Delete(
     *      path="/log_out",
     *      summary="Remove the specified Users from storage",
     *      tags={"Users"},
     *      description="Delete Users",
     *      produces={"application/json"},
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function logOut()
    {

        JWTAuth::parseToken()->invalidate();
        return response()->json(['success' => true, 'message' => 'Log out successfully'], 200, []);
    }

    /**
     *
     * @SWG\Get(
     *      path="/getAllRoles",
     *      summary="Get a listing of the Roles.",
     *      tags={"Users"},
     *      description="Get all Roles",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Users")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getAllRoles()
    {
        return response()->json(['success' => true, 'data' => Role::all(), 'message' => 'Roles retrieved successfully'], 200);

    }
}