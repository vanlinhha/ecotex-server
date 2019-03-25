<?php

namespace App\Repositories;

use App\Models\AttachedFiles;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttachedFilesRepository
 * @package App\Repositories
 * @version March 23, 2019, 6:14 pm ICT
 *
 * @method AttachedFiles findWithoutFail($id, $columns = ['*'])
 * @method AttachedFiles find($id, $columns = ['*'])
 * @method AttachedFiles first($columns = ['*'])
*/
class AttachedFilesRepository extends BaseRepository
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
        return AttachedFiles::class;
    }
}
