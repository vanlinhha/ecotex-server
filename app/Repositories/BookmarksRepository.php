<?php

namespace App\Repositories;

use App\Models\Bookmarks;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BookmarksRepository
 * @package App\Repositories
 * @version March 10, 2019, 2:13 pm ICT
 *
 * @method Bookmarks findWithoutFail($id, $columns = ['*'])
 * @method Bookmarks find($id, $columns = ['*'])
 * @method Bookmarks first($columns = ['*'])
*/
class BookmarksRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'follower_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bookmarks::class;
    }
}
