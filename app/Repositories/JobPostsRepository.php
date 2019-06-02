<?php

namespace App\Repositories;

use App\Models\JobPosts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class JobPostsRepository
 * @package App\Repositories
 * @version June 2, 2019, 2:36 pm ICT
 *
 * @method JobPosts findWithoutFail($id, $columns = ['*'])
 * @method JobPosts find($id, $columns = ['*'])
 * @method JobPosts first($columns = ['*'])
*/
class JobPostsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return JobPosts::class;
    }
}
