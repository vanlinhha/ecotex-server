<?php

namespace App\Http\Controllers\API;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Image;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\RestController;
use App\Models\Users;
use Tymon\JWTAuth\Token;

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

    protected $user;

    public function authenticate(Request $request)
    {
        $timeExp     = (time() + (24 * 60 * 60)) * 1000;
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => __('invalid_credentials')], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => __('could_not_create_token')], 500);
        }
        $user = JWTAuth::user();
//        if ($user->roles()->get(['id'])->count()) {
//            $roles = $user->roles()->get()[0]['id'];
//        } else {
//            $roles = 0;
//        }

        $mainProductGroups   = $user->mainProductGroups()->get(['*', 'name', 'product_group_id', 'percent']);
        $mainServices        = $user->services()->get(['*', 'name', 'service_id', 'role_id']);
        $mainExportCountries = $user->mainExportCountries()->get(['*', 'country_id', 'percent']);
        $mainMaterialGroups  = $user->mainMaterialGroups()->get(['*', 'name', 'material_group_id', 'percent']);
        $mainTargets         = $user->mainTargets()->get(['*', 'name', 'target_group_id', 'percent']);
        $mainSegmentGroups   = $user->mainSegmentGroups()->get(['*', 'name', 'segment_group_id', 'percent']);
        $role_type_ids       = $user->roleTypes()->pluck('role_type_id');
        $role                = $user->roles()->get();
        $bookmarks           = $user->bookmarks()->get();

        $user['bookmarks']             = $bookmarks;
        $user['role']                  = $role;
        $user['role_type_ids']         = $role_type_ids;
        $user['main_product_groups']   = $mainProductGroups;
        $user['main_services']         = $mainServices;
        $user['main_material_groups']  = $mainMaterialGroups;
        $user['main_segment_groups']   = $mainSegmentGroups;
        $user['main_target_groups']    = $mainTargets;
        $user['main_export_countries'] = $mainExportCountries;
        //        $user['role_id']               = $roles;


        return response()->json(['success' => true, 'data' => ['token' => $token, 'user' => $user, 'expired_at' => $timeExp], 'message' => 'Log in successfully'], 201, []);
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
     *          name="first_name",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="last_name",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="role_id",
     *          in="query",
     *          type="integer",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="type",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="phone",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="country_id",
     *          in="query",
     *          type="integer",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="company_name",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="brief_name",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="company_address",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="website",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="description",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
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
        $main_product_group_IDs  = json_decode($request->main_product_groups);
        $main_material_group_IDs = json_decode($request->main_material_groups);
        $main_segment_group_IDs  = json_decode($request->main_segment_groups);
        $main_target_group_IDs   = json_decode($request->main_target_groups);
        $role_types              = json_decode($request->role_types);

        $validator = Validator::make($request->all(), [
            'email'      => 'string|email|max:255|unique:users',
            'password'   => 'required|string|min:6',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => __($validator->errors()->toJson()), 'success' => false], 422);
        }

        $user = Users::create([
            'email'                        => $request->post('email'),
            'password'                     => Hash::make($request->post('password')),
            'first_name'                   => $request->post('first_name'),
            'last_name'                    => $request->post('last_name'),
            'phone'                        => $request->post('phone'),
            'country_id'                   => $request->post('country_id'),
            'company_name'                 => $request->post('company_name'),
            'company_address'              => $request->post('company_address'),
            'brief_name'                   => $request->post('brief_name'),
            'website'                      => $request->post('website'),
            'description'                  => $request->post('description'),
            'identity_card'                => $request->post('identity_card'),
            'minimum_order_quantity'       => $request->post('minimum_order_quantity'),
            'establishment_year'           => $request->post('establishment_year'),
            'business_registration_number' => $request->post('business_registration_number'),
            'form_of_ownership'            => $request->post('form_of_ownership'),
            'number_of_employees'          => $request->post('number_of_employees'),
            'floor_area'                   => $request->post('floor_area'),
            'area_of_factory'              => $request->post('area_of_factory'),
            'commercial_service_type'      => $request->post('commercial_service_type'),
            'revenue_per_year'             => $request->post('revenue_per_year'),
            'pieces_per_year'              => $request->post('pieces_per_year'),
            'compliance'                   => $request->post('compliance'),
            'activation_code'              => str_random(20),
            'is_activated'                 => 0,
        ]);

        $this->user = $user;

        Mail::raw('Sign up successfully, click on this link to complete your registration, ' . env('APP_CLIENT_BASE_PATH') . '/verify/' . $this->user->id . '/' . $this->user->activation_code . ' .Thank you!', function ($mail) {
            $mail->to($this->user->email)
                ->from('support@ecotexvietnam.com', 'Ecotex')
                ->subject('One more step to join us, ' . $this->user->first_name . '!');
        });

        if (intval($request->role_id)) {
            $user->roles()->attach(intval($request->role_id));
        }

        $user->mainProductGroups()->sync($main_product_group_IDs);
        $user->mainMaterialGroups()->sync($main_material_group_IDs);
        $user->mainTargets()->sync($main_target_group_IDs);
        $user->mainSegmentGroups()->sync($main_segment_group_IDs);
        $user->roleTypes()->sync($role_types);

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
     * @SWG\Put(
     *      path="/users/brands/{id}",
     *      summary="Update brands for company",
     *      tags={"Users"},
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Users",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *     @SWG\Parameter(
     *     name="brands",
     *     description="ID of the order that needs to be deleted",
     *     type="object",
     *     in="body",
     *     @SWG\Schema(ref="#/definitions/Users"),
     *     ),
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
    public function updateBrands($id, Request $request)
    {
        Users::findOrFail($id)->update([
            'brands' => $request->brands
        ]);
        return response()->json(['success' => true, 'data' => [], 'message' => 'Update brands successfully'], 200);
    }

    /**
     *
     * @SWG\Get(
     *      path="/roles",
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

    /**
     *
     * @SWG\Get(
     *      path="/permissions",
     *      summary="Get a listing of the Permissions.",
     *      tags={"Users"},
     *      description="Get all Permissions",
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
    public function getAllPermissions()
    {
        return response()->json(['success' => true, 'data' => Permission::all(), 'message' => 'Permissions retrieved successfully'], 200);
    }

    public function updatePermissions(Request $request)
    {
        $role = Role::find($request->role_id);
        if (empty($role)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Role not found'], 404);
        }
        $permission_ids = json_decode($request->permission_ids);
        $role->syncPermissions($permission_ids);
        $permissions = $role->permissions()->get();
        return response()->json(['success' => true, 'data' => $permissions, 'message' => 'Update permissions successfully'], 200);
    }

    public function getRolePermissions($id, Request $request)
    {
        $role = Role::find($id);
        if (empty($role)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Role not found'], 404);
        }

        $permissions = $role->permissions()->get();
        return response()->json(['success' => true, 'data' => $permissions, 'message' => 'Permissions retrieved successfully'], 200);
    }

    public function syncRoleUser(Request $request)
    {
        $role = Role::find($request->role_id);
        if (empty($role)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'Role not found'], 404);
        }

        $user = Users::find($request->user_id);
        if (empty($user)) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'User not found'], 404);
        }

        $user->syncRoles([intval($request->role_id)]);

        return response()->json(['success' => true, 'data' => $user->roles()->get(), 'message' => 'Sync role to user successfully'], 200);
    }

    public function getAllRolesAndPermissions()
    {
        $roles = Role::all();
        if (!count($roles)) {
            return response()->json(['success' => false, 'data' => $roles, 'message' => 'No roles found'], 404);
        }
        foreach ($roles as $role) {
            $role['permissions'] = Role::find($role['id'])->permissions()->pluck('id');
        }
        return response()->json(['success' => true, 'data' => $roles, 'message' => 'Roles and permissions retrieved successfully'], 200);

    }

    public function upload(Request $request){
        dd($request->input());

        $image = $request->file('file');
        return gettype($image);

        $input = $request->all();
        $file = $request->file('file');
        $url = "images/photo-" . uniqid() . '.png';

        $path = storage_path('app/public/') . $url;
        \Image::make($image)->resize(800, 600)->save($path);

        return env('APP_URL') . '/storage/' .  $url;
    }

    public function testRole(){
        return JWTAuth::parseToken()->authenticate()->roles()->get();
    }

}