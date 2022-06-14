<?php namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\BaseRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryInterface
{
    // model property on class instances
    protected $model;

    /**
     * @desc: injecting model to base repository
     * @param eloquent $model
     */

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
    * @param $query (Model)
    * @param array $sort
    * @return ?Model
    */
    public function setSort($query, array $sort = [])
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }
        return $query;
    }
    /**
    * @param array $columns
    * @param array $relations
    * @return collectionsall_paginate
    */
    public function all(array $columns = ['*'], array $relations = [],array $orderBy = []): Collection
    {
        $result = "";
        $query =  $this->model->with($relations);
        if(is_array($orderBy) && count($orderBy)>0)
            $query = $this->setSort($query,$orderBy);
        $result = $query->get($columns);
        return $result;
    }

    /**
    * @param array $columns
    * @param array $relations
    * @return 
    */
    public function all_paginate(array $columns = ['*'], array $relations = [],array $orderBy = [],$per_page = 0)
    {
        $result = "";
        $query =  $this->model->with($relations);
        if(is_array($orderBy) && count($orderBy)>0)
            $query = $this->setSort($query,$orderBy);
        if($per_page > 0)
            $result = $query->paginate($per_page,$columns);
        else
            $result = $query->get($columns);
        return $result;
    }

    /**
    * @param $data array
    * @return model
    */
    public function create(array $data): Model
    {
        $model = $this->model->create($data);
        return $model->fresh();
    }

    /**
    * @param 1. data array 2. record id
    * @return Model
    */
    public function update(array $data, $id): Model
    {
        $record = $this->model->find($id);
        $record->update($data);
        return $record; 
    }

    /**
    * @param $id (record id)
    * @return boolean
    */
    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    /**
    * @param record $id
    * @param array $columns
    * @param array $relations
    * @param: array $appends
    * @return Model
    */
    public function show(
        $id,
        array $columns = ['*'],
        array $relations = []
    ): ?Model
    {
        return $this->model->select($columns)->with($relations)->find($id);
    }

    /**
    * @param null
    * @return model
    */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
    * @param model
    * @return $this
    */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
    * @param relation names, $id
    * @return models with relations
    */
    public function with($relations,$id): Model
    {
        return $this->model->with($relations)->find($id);
    }
    /**
    * @param null
    * @return attributes (model attributes)
    */
    public function fillables()
    {
        return $this->model->getFillables();
    }
    public function batchInsert($data = array())
    {
        return $this->model->insert($data);
    }
    /**
    * @param $column
    * @param array $values
    * @param array $conditions [['field','=','value'],['field2','=','value2']]
    * @param array $relations
    * @param array $columns
    * @param array $relations
    * @return collections
    */
    public function getRecordsByColumn($column,array $values = [],
                            array $conditions = [],array $columns = ['*'], array $relations = []): Collection
    {
        $query = $this->model->whereIn($column,$values);
                if(is_array($conditions) && count($conditions)>0)
                    $query = $query->where($conditions);
        return $query->with($relations)->get($columns);
    }

    /**
    * @summary: delete all data of a table by the given field name and value
    * @param: $field_name
    * @param: $field_value ($id)
    * @return: boolean (true/false)
    * @author: Gulzade
    * @date February 1 2021
    * @last_updated_By 
    * @last_updated_Date
    */  
    public function deleteData($field_name,$field_value): bool
    {
        return $this->model->where($field_name,$field_value)->delete();
    }

    /**
    * @param $column
    * @param array $values
    * @param array $conditions [['field','=','value'],['field2','=','value2']]
    * @param array $relations
    * @param array $columns
    * @param array $relations
    * @param array $per_page (default 50)
    * @return \Illuminate\Pagination\Paginator 
    */
    public function getRecordsByColumnWithPagination($column,array $values = [],
                            array $conditions = [],array $columns = ['*'], array $relations = [],$per_page = 50)
    {
        //DB::connection()->enableQueryLog();
        $query = $this->model->whereIn($column,$values);
                if(is_array($conditions) && count($conditions)>0)
                    $query = $query->where($conditions);
                $query = $query->with($relations)->paginate($per_page,$columns);     
        //dd(DB::getQueryLog());
        return $query;
    }

    /**
    * @param record $id
    * @param array $columns
    * @param array $relations
    * @param: array $appends
    * @return Model
    */
    public function finRecords(array $conditions = [], array $columns = ['*'],array $relations = []): collection
    {
        $query = $this->model->select($columns);
                 if(is_array($conditions) && count($conditions)>0)
                     $query = $query->where($conditions);
                 $query = $query->with($relations)->get();

        return $query;
    }

    /**
    * @param record $id
    * @param array $columns
    * @param array $relations
    * @param: array $appends
    * @return Model
    */
    public function finRecordsByPagination(array $conditions = [], array $columns = ['*'],array $relations = [],array $orderBy = [],$per_page = 50)
    {
        $query = $this->model->select($columns);
                 if(is_array($conditions) && count($conditions)>0)
                     $query = $query->where($conditions);
                 if(is_array($orderBy) && count($orderBy)>0)
                     $query = $this->setSort($query,$orderBy);
                 $query = $query->with($relations)->paginate($per_page);

        return $query;
    }
}