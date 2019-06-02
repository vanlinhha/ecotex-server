<?php

namespace App\Repositories;

use App\Models\AppliedCV;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AppliedCVRepository
 * @package App\Repositories
 * @version June 2, 2019, 4:35 pm ICT
 *
 * @method AppliedCV findWithoutFail($id, $columns = ['*'])
 * @method AppliedCV find($id, $columns = ['*'])
 * @method AppliedCV first($columns = ['*'])
*/
class AppliedCVRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'job_post_id',
        'education',
        'experience',
        'skill',
        'foreign_language'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AppliedCV::class;
    }
}
