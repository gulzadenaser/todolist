<?php

namespace App\Http\Controllers\ApiControllers\Vehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Vehicles\VehicleService;
use App\Services\Vehicles\CategoryService;
use App\Traits\ApiResponser;
use App\Http\Requests\Vehicles\VehicleRequest as vehRequest;

class VehicleController extends Controller
{
    //include traits function inside this controller
    use ApiResponser;
    //local service vars
    protected $vehicleService;
    protected $categoryService;
    //constructor
    public function __construct(VehicleService $vehicleService,CategoryService $categoryService)
	{
		$this->vehicleService = $vehicleService;
		$this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //check if the request is API or through browser
        //if ($request->isJson()) {
        if (1) {
            // return JSON-formatted response
            $vehicles = $this->vehicleService->all(['*'],['Category']);
            return $this->validResponse($vehicles, $this->vehicleService->http_code);
        } else {

            // return HTML response
        }
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
    public function store(vehRequest $request)
    {
        $data = getRequestData($request->only($this->vehicleService->fillables()));
        $result = ['status' => 200];
        try{
            $result['data']   = $this->vehicleService->create($data); 
            $result['status'] = $this->vehicleService->http_code;
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
    public function update(vehRequest $request, $id)
    {
        $data = getRequestData($request->only($this->vehicleService->fillables()));
        $result = ['status' => 200];
        try{
            $result['data'] = $this->vehicleService->update($data,$id); 
            $result['status'] = $this->vehicleService->http_code;
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
            $result['data'] = $this->vehicleService->deleteVehicle($id); 
            return $this->successResponse($result['data'],$result['status']);
        } catch(Exception $e){
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  
            return $this->errorResponse($result['error'],$result['status']); 
        }
    }
}
