<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="JobPosts",
 *      required={"creator_id", "title", "amount", "salary", "welfare", "position"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="creator_id",
 *          description="creator_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="division",
 *          description="division",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="salary",
 *          description="salary",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="welfare",
 *          description="welfare",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="position",
 *          description="position",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
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
class JobPosts extends Model
{
//    use SoftDeletes;

    public $table = 'job_posts';
    

//    protected $dates = ['deleted_at'];


    public $fillable = [
        'creator_id',
        'title',
        'division',
        'amount',
        'salary',
        'welfare',
        'position',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'creator_id' => 'string',
        'title' => 'string',
        'division' => 'string',
        'amount' => 'string',
        'salary' => 'string',
        'welfare' => 'string',
        'position' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'creator_id' => 'required',
        'title' => 'required',
        'amount' => 'required',
        'salary' => 'required',
        'welfare' => 'required',
        'position' => 'required'
    ];

    
}
