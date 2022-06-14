<?php namespace App\Repositories\Eloquent\Vehicles\Interfaces;
/**
 * Repository Interface to make repository abstract
 */
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface VehicleRepositoryInterface
{
    /**
     * set model
     */
    public function setModel(Model $model);
}