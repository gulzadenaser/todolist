<?php namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
/**
 * Attendance Repository Interface to make repository abstract
 */
interface BaseRepositoryInterface
{

    /**
    * @param $query (Model)
    * @param array $sort
    * @return ?Model
    */
    public function setSort($query, array $sort = []);
    /**
    * @param array $columns
    * @param array $relations
    * @return collections
    */
    public function all(array $columns = ['*'], array $relations = [],array $orderBy = []): Collection;
     /**
    * @param array $columns
    * @param array $relations
    * @return \Illuminate\Pagination\Paginator
    */
    public function all_paginate(array $columns = ['*'], array $relations = [],array $orderBy = [],$per_page = 0);
    /**
    * @param $data array
    * @return Illuminate\Database\Eloquent\Model
    */
    public function create(array $data): Model;

    /**
    * @param 1. data array 2. record id
    * @return Bolean (true/false)
    */
    public function update(array $data, $id): Model;

    /**
    * @param $id (record id)
    * @return boolean
    */
    public function delete($id);
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
    ): ?Model;
    /**
    * @param null
    * @return model
    */
    public function getModel();
     /**
    * @param model
    * @return $this
    */
    public function setModel(Model $model);
    /**
    * @param relation names,$id
    * @return models with relations
    */
    public function with($relations,$id);
    /**
    * @param null
    * @return attributes (model attributes)
    */
    public function fillables();
    /**
     * insert batch data
     * @param: $data Array
     * @return: Mix 
     */
    public function batchInsert($data = array());

    /**
    * @param $column
    * @param array $values
    * @param array $relations
    * @param array $columns
    * @param array $relations
    * @return collections
    */
    public function getRecordsByColumn($column,array $values = [],
                        array $conditions = [], array $columns = ['*'], array $relations = []): Collection;
    
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
    public function deleteData($field_name,$field_value): bool;

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
                            array $conditions = [],array $columns = ['*'], array $relations = [],$per_page = 50);

    /**
    * @param conditions $conditions
    * @param array $columns
    * @param array $relations
    * @return Model
    */
    public function finRecords(
        array $conditions = [],
        array $columns = ['*'],
        array $relations = []
    ): collection;

    public function finRecordsByPagination(array $conditions = [], array $columns = ['*'],array $relations = [],array $orderBy = [],$per_page = 50);
}