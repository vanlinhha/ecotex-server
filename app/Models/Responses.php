<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Responses",
 *      required={"product_post_id", "owner_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="product_post_id",
 *          description="product_post_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="owner_id",
 *          description="owner_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="accepted_quantity",
 *          description="accepted_quantity",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="suggest_quantity",
 *          description="suggest_quantity",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="accepted_price",
 *          description="accepted_price",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="suggest_price",
 *          description="suggest_price",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="accepted_delivery",
 *          description="accepted_delivery",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="suggest_delivery",
 *          description="suggest_delivery",
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
class Responses extends Model
{
    use SoftDeletes;

    public $table = 'responses';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'product_post_id',
        'owner_id',
        'accepted_quantity',
        'suggest_quantity',
        'accepted_price',
        'suggest_price',
        'accepted_delivery',
        'suggest_delivery',
        'comment'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'product_post_id'   => 'integer',
        'owner_id'          => 'integer',
        'accepted_quantity' => 'integer',
        'suggest_quantity'  => 'string',
        'accepted_price'    => 'integer',
        'suggest_price'     => 'string',
        'accepted_delivery' => 'integer',
        'suggest_delivery'  => 'string',
        'comment'  => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'product_post_id' => 'required',
        'owner_id'        => 'required'
    ];

    public function product_post(){
        return $this->belongsTo(ProductPosts::class, 'product_post_id', 'id');
    }

    public function getAcceptedQuantityAttribute($var)
    {
        return $var == 1 ? true : false;
    }

    public function getAcceptedPriceAttribute($var)
    {
        return $var == 1 ? true : false;
    }

    public function getAcceptedDeliveryAttribute($var)
    {
        return $var == 1 ? true : false;
    }

    public function getCreatedAtAttribute($date)
    {
        return strtotime($date) * 1000;
    }

    protected $hidden = ['updated_at', 'deleted_at', 'product_post_id'];

}
