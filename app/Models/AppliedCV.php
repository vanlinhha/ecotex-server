<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="AppliedCV",
 *      required={"user_id", "job_post_id"},
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
 *          property="job_post_id",
 *          description="job_post_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="education",
 *          description="education",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="experience",
 *          description="experience",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="skill",
 *          description="skill",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="foreign_language",
 *          description="foreign_language",
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
class AppliedCV extends Model
{
//    use SoftDeletes;

    public $table = 'applied_c_vs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'job_post_id',
        'education',
        'experience',
        'skill',
        'foreign_language'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'job_post_id' => 'integer',
        'education' => 'string',
        'experience' => 'string',
        'skill' => 'string',
        'foreign_language' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'job_post_id' => 'required',
        'foreign_language' => 'other text text'
    ];

    
}
