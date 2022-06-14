<?php namespace App\Repositories\Eloquent\Vehicles;

use App\Repositories\Eloquent\Vehicles\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicles\Vehicle;

class VehicleRepository extends BaseRepository implements VehicleRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(Vehicle $model)
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