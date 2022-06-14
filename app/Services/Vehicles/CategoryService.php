<?php
/**
 * @desc: Category service
 */
namespace App\Services\Vehicles;

use Illuminate\Support\Facades\DB;
use App\Repositories\Eloquent\Vehicles\Interfaces\CategoryRepositoryInterface;

class categoryService
{
    //set http code
    public $http_code = 200;
    /**
     * @var categoryRepository
     */
    protected $categoryRepository;
    /**
     * @param: CategoryRepositoryInterface  $categoryRepository;
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    
    /**
     * @return: all records object
     */
    public function all(array $columns = ['*'], array $relations = [], $orderBy = [],$per_page = 0)
    {
        return $this->categoryRepository->all_paginate($columns,$relations,$orderBy,$per_page);
    }

    /**
     * @return: all records with condition records object
     */
    public function allRecordsWCondition(array $conditions = [], array $columns = ['*'],array $relations = [],$per_page = 0)
    {
        if($per_page == 0)
            return $this->categoryRepository->finRecords($conditions, $columns,$relations);
        else
            return $this->categoryRepository->finRecordsByPagination($conditions, $columns,$relations,$per_page);
        
    }

    /**
     * @return: all records object
     */
    public function show($id,array $columns = ['*'], array $relations = [])
    {
        return $this->categoryRepository->show($id,$columns,$relations);
    }

    /**
     * Store a newly created resource in storage.
     * @param: $data (Array)
     */
    public function create(Array $data)
    {
        //Check if the paramter is a data array
        if(is_array($data) && count($data) > 0)
        {
           $result = $this->categoryRepository->create($data);
           return $result;
        }
        else
        {
            $this->http_code = 422;
            return FALSE;
        }
    }

    /**
     * @desc: update an existing record
     * @param: array $data, $id (leave type id)
     */
    public function update(Array $data, $id)
    {
        if(!$categoryObj = $this->show($id))
            return "No Data Found !";
        //Check if the paramter is a data array
        if(is_array($data) && count($data) > 0 && $id)
        {

            $category = "";
            DB::beginTransaction();
            try{
                $category = $this->categoryRepository->update($data,$id);
                DB::commit();

            }catch(Exception $e)
            { 
               DB::rollBack();
               $this->http_code = 500;
               return $e;

            }
            return $category;
        }

    }

    /**
     * @desc: update an existing record
     * @param: array $data, $id (leave type id)
     * @return: return true/false if deleted
     */
    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }

    /**
     * @return: model fillable attribute
     */
    public function fillables()
    {
        return $this->categoryRepository->fillables();
    }
     
}