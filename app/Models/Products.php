<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Products",
 *      required={"user_id", "product_group_id", "name", "minimum_order_quantity_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="product_group_id",
 *          description="product_group_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="is_main_product",
 *          description="is_main_product",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="minimum_order_quantity_id",
 *          description="minimum_order_quantity_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="lead_time",
 *          description="lead_time",
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
class Products extends Model
{
    use SoftDeletes;

    public $table = 'products';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'product_group_id',
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'product_group_id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    public function productImages(){
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'product_group_id' => 'required',
        'name' => 'required',
    ];

    protected $hidden = ['deleted_at' , 'product_id'];


}
