<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                return response()->json(['error' => __('invalid_credentials')], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => __('could_not_create_token')], 500);
        }

        return response()->json(compact('token'), 201, []);
    }

    /**
     *
     * @return Response
     *
     * @SWG\Post(
     *      path="/register",
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
            'email'    => 'string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        $user = Users::create([
            'email'    =>    $request->post('email'),
            'password' => Hash::make($request->post('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json($user);
    }

    static function makeInstance()
    {
        return new self();
    }
}