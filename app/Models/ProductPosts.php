<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="ProductPosts",
 *      required={"product_group_id", "quantity", "specification", "creator_id", "title"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
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
 *          property="quantity",
 *          description="quantity",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="target_price",
 *          description="target_price",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="specification",
 *          description="specification",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="target_group_id",
 *          description="target_group_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="creator_id",
 *          description="creator_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
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
class ProductPosts extends Model
{
    use SoftDeletes;

    public $table = 'product_posts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'product_group_id',
        'quantity',
        'target_price',
        'specification',
        'target_group_id',
        'creator_id',
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'product_group_id' => 'integer',
        'quantity' => 'integer',
        'target_price' => 'float',
        'specification' => 'string',
        'target_group_id' => 'integer',
        'creator_id' => 'integer',
        'title' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'product_group_id' => 'required',
        'quantity' => 'required',
        'specification' => 'required',
        'target_group_id' => 'segment_group_id integer text',
        'creator_id' => 'required',
        'title' => 'required'
    ];

    
}
