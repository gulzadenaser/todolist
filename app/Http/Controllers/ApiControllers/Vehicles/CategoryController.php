<?php

namespace App\Http\Controllers\ApiControllers\Vehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Vehicles\CategoryService;
use App\Traits\ApiResponser;
use App\Http\Requests\Vehicles\CategoryRequest as catRequest;

class CategoryController extends Controller
{
    //include traits function inside this controller
    use ApiResponser;
    //local service vars
    protected $categoryService;
    //constructor
    public function __construct(CategoryService $categoryService)
	{
		$this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check if the request is API or through browser
        // return JSON-formatted response
        $categories = $this->categoryService->all();
        return $this->validResponse($categories, $this->categoryService->http_code);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(catRequest $request)
    {
        $data = getRequestData($request->only($this->categoryService->fillables()));
        $result = ['status' => 200];
        try{
            $result['data']   = $this->categoryService->create($data); 
            $result['status'] = $this->categoryService->http_code;
            return $this->successResponse($result['data'],$result['status']);
        } catch(Exception $e){
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  
            return $this->errorResponse($result['error'],$result['status']); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(catRequest $request, $id)
    {
        $data = getRequestData($request->only($this->categoryService->fillables()));
        $result = ['status' => 200];
        try{
            $result['data'] = $this->categoryService->update($data,$id); 
            $result['status'] = $this->categoryService->http_code;
            return $this->successResponse($result['data'],$result['status']);
        } catch(Exception $e){
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  
            return $this->errorResponse($result['error'],$result['status']); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //remove records from database
        $result = ['status' => 200];
        try{
            $result['data'] = $this->categoryService->deleteCategory($id); 
            return $this->successResponse($result['data'],$result['status']);
        } catch(Exception $e){
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  
            return $this->errorResponse($result['error'],$result['status']); 
        }
    }
}
