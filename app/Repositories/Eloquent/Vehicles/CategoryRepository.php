<?php namespace App\Repositories\Eloquent\Vehicles;

use App\Repositories\Eloquent\Vehicles\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicles\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * set model
     */
    public function setRepositoryModel(Model $model)
    {
        $this->setModel($model);
    }
}