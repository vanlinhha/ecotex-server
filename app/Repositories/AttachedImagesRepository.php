<?php

namespace App\Repositories;

use App\Models\AttachedImages;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttachedImagesRepository
 * @package App\Repositories
 * @version March 23, 2019, 11:51 pm ICT
 *
 * @method AttachedImages findWithoutFail($id, $columns = ['*'])
 * @method AttachedImages find($id, $columns = ['*'])
 * @method AttachedImages first($columns = ['*'])
*/
class AttachedImagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'post_id',
        'url',
        'name',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttachedImages::class;
    }
}
