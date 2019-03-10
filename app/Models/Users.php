<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent\NestedAttributes\Traits\HasNestedAttributesTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * @SWG\Definition(
 *      definition="Users",
 *      required={"email", "type", "first_name", "last_name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="first_name",
 *          description="first_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="last_name",
 *          description="last_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="country_id",
 *          description="country_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="company_name",
 *          description="company_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="brief_name",
 *          description="brief_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="company_address",
 *          description="company_address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="website",
 *          description="website",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="is_paid",
 *          description="is_paid",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="identity_card",
 *          description="identity_card",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="establishment_year",
 *          description="establishment_year",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="business_registration_number",
 *          description="business_registration_number",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="form_of_ownership",
 *          description="form_of_ownership",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="number_of_employees",
 *          description="number_of_employees",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="floor_area",
 *          description="floor_area",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="area_of_factory",
 *          description="area_of_factory",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="commercial_service_type",
 *          description="commercial_service_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="revenue_per_year",
 *          description="revenue_per_year",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="pieces_per_year",
 *          description="pieces_per_year",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="compliance",
 *          description="compliance",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="activation_code",
 *          description="activation_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Users extends Authenticatable implements JWTSubject
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasNestedAttributesTrait;

    public $table = 'users';

    public $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'country_id',
        'company_name',
        'brief_name',
        'company_address',
        'website',
        'description',
        'address',
        'identity_card',
        'establishment_year',
        'business_registration_number',
        'form_of_ownership',
        'number_of_employees',
        'floor_area',
        'area_of_factory',
        'commercial_service_type',
        'revenue_per_year',
        'pieces_per_year',
        'compliance',
        'activation_code',
        'is_activated',
        'minimum_order_quantity'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'password' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'phone' => 'string',
        'country_id' => 'integer',
        'company_name' => 'string',
        'brief_name' => 'string',
        'company_address' => 'string',
        'website' => 'string',
        'description' => 'string',
        'address' => 'string',
        'identity_card' => 'string',
        'establishment_year' => 'integer',
        'business_registration_number' => 'integer',
        'minimum_order_quantity' => 'integer',
        'form_of_ownership' => 'string',
        'number_of_employees' => 'integer',
        'floor_area' => 'double',
        'area_of_factory' => 'double',
        'commercial_service_type' => 'string',
        'revenue_per_year' => 'double',
        'pieces_per_year' => 'integer',
        'compliance' => 'string',
        'activation_code' => 'string'
    ];

    protected $hidden = ['password', 'pivot', 'created_at', 'updated_at'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required|email',
        'type' => 'required',
        'first_name' => 'required',
        'last_name' => 'required'
    ];

    protected $nested = ['mainSegmentGroups', 'comments', 'brands'];


    public function brands(){
        return $this->hasMany(Brand::class, 'user_id', 'id');
    }

    public function mainProductGroups(){
        return $this->belongsToMany(ProductGroups::class, "main_product_groups", 'user_id', 'product_group_id');
    }

    public function mainMaterialGroups(){
        return $this->belongsToMany(MaterialGroups::class, "main_material_groups", 'user_id', 'material_group_id');
    }

    public function mainTargets(){
        return $this->belongsToMany(TargetGroups::class, 'main_targets', 'user_id','target_group_id');
    }

    public function mainExportCountries(){
        return $this->belongsToMany(Countries::class, 'main_export_countries', 'user_id','country_id');
    }

    public function mainSegmentGroups(){
        return $this->belongsToMany(SegmentGroups::class, 'main_segment_groups', 'user_id','segment_group_id');
    }

    public function roleTypes(){
        return $this->belongsToMany(RoleTypes::class, 'user_role_types', 'user_id','role_type_id');
    }

    public function services(){
        return $this->belongsToMany(Services::class, 'main_services', 'user_id','service_id');
    }


    public function getInfo(){

    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

}
