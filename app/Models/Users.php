<?php

namespace App\Models;

use Eloquent as Model;
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
 *          property="country",
 *          description="country",
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

    public $table = 'users';

    public $fillable = [
        'email',
        'password',
        'type',
        'first_name',
        'last_name',
        'phone',
        'country',
        'company_name',
        'brief_name',
        'company_address',
        'website',
        'description',
        'is_paid',
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
        'activation_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'password' => 'string',
        'type' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'phone' => 'string',
        'country' => 'string',
        'company_name' => 'string',
        'brief_name' => 'string',
        'company_address' => 'string',
        'website' => 'string',
        'description' => 'string',
        'is_paid' => 'integer',
        'address' => 'string',
        'identity_card' => 'string',
        'establishment_year' => 'integer',
        'business_registration_number' => 'integer',
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

    protected $hidden = ['password'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required|email',
        'password' => 'password',
        'type' => 'required',
        'first_name' => 'required',
        'last_name' => 'required'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    
}
