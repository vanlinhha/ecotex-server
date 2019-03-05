<?php

namespace App\Models;

use Eloquent as Model;

/**
 * @SWG\Definition(
 *      definition="MainSegmentGroups",
 *      required={"user_id", "segment_group_id"},
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
 *          property="segment_group_id",
 *          description="segment_group_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="percent",
 *          description="percent",
 *          type="number",
 *          format="float"
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
class MainSegmentGroups extends Model
{

    public $table = 'main_segment_groups';
    


    public $fillable = [
        'user_id',
        'segment_group_id',
        'percent'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'segment_group_id' => 'integer',
        'percent' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'segment_group_id' => 'required'
    ];

    protected $hidden = ['updated_at', 'created_at', 'deleted_at', 'pivot'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
//    public function users()
//    {
//        return $this->belongsTo(\App\Models\Users::class, 'user_id', 'id');
//    }
}
