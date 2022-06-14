<?php

namespace App\Http\Controllers\WebControllers\Vehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Vehicles\VehicleService;
use App\Services\Vehicles\CategoryService;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{

    //local service vars
    protected $vehicleService;
    protected $categoryService;
    //constructor
    public function __construct(VehicleService $vehicleService,CategoryService $categoryService)
	{
        $this->middleware('auth');
		$this->vehicleService = $vehicleService;
		$this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryService->all();
        $data['categories'] = $categories;
        return view('vehicles.create',$data);
        
    }
    //get list by ajax onload 
    public function getList()
    {
        // return JSON-formatted response
        $vehicles = $this->vehicleService->all(['*'],['Category']);
        $data['vehicles'] = $vehicles;

        $data_result = [];
        $counter = 1;
        foreach ($vehicles as $vehicle)
        {
            $data = [
                'no'         => $counter,
                'category'   => $vehicle->category->name,
                'color'      => $vehicle->color,
                'model'      => $vehicle->model,
                'make'       => $vehicle->make,
                'registration_no'   => $vehicle->registration_no,
                'edit_btn'   => "<a class='dt-button buttons-copy buttons-html5' href='".route('vehicle.edit', ['vehicle' => $vehicle->id])."'><i>Edit</i></a>",
                'del_btn'    => "<a class='dt-button buttons-delete buttons-html5' onclick=\"return confirm('Are you sure?')\" href='".route('vehicle-delete', $vehicle->id)."'><i>Delete</i></a>",
                ];
            array_push($data_result,$data);
            $counter++;
        }
        
        $response = array(
            "data" => $data_result
        );
        return response()->json($response);
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
    public function store(Request $request)
    {
        //set validation
        $validator = validator()->make( $request->all(), [
            'category_id'       => 'required|integer',
            'color'             => 'required|string|Max:250',
            'model'             => 'required|string|Max:250',
            'make'              => 'required|string|Max:250',
            'registration_no'   => 'required|string|Max:250',     
        ]);
        //check validation
        if ($validator->fails())
        {
            return redirect()->route('vehicle.index')->with('error',$validator->messages());       
        }
        
        $data = getRequestData($request->only($this->vehicleService->fillables()));
       
        $result = ['status' => 200];
        DB::beginTransaction();
        try{
            $result['data']   = $this->vehicleService->create($data); 
            DB::commit();
            return redirect()->route('vehicle.index')->with('message','Vehicle registered successfully');
           
        } catch(Exception $e){
            DB::rollBack();
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  
            return redirect()->route('vehicle.index')->with('error',$result['error']);
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
        //check if object found
        $vehicle = $this->vehicleService->show($id);
        if(!$vehicle)
            die('Invalid Request');    
        $data = [];
        //get all existence items
        $categories = $this->categoryService->all();
        $data['categories'] = $categories;
        $data['vehicle'] = $vehicle;

        return view('vehicles.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //set validation
         $validator = validator()->make( $request->all(), [
            'category_id'       => 'required|integer',
            'color'             => 'required|string|Max:250',
            'model'             => 'required|string|Max:250',
            'make'              => 'required|string|Max:250',
            'registration_no'   => 'required|string|Max:250',     
        ]);
        //check validation
        if ($validator->fails())
        {
            return redirect()->route('vehicle.edit',$id)->with('error',$validator->messages());       
        }
        $data = getRequestData($request->only($this->vehicleService->fillables()));
        try{
            $result['data'] = $this->vehicleService->update($data,$id); 
            return redirect()->route('vehicle.index',$id)->with('message','Vehicle data updated successfully');
        } catch(Exception $e){
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  

            return redirect()->route('vehicle.edit',$id)->with('error',$result['error']);
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

        //check if object found
        $vehicle = $this->vehicleService->show($id);
        if(!$vehicle)
            die('Invalid Request'); 
        //remove records from database
        $result = ['status' => 200];
        try{
            $result['data'] = $this->vehicleService->deleteVehicle($id); 
            return redirect()->route('vehicle.index',$id)->with('message','Vehicle deleted successfully');
        } catch(Exception $e){
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  
            return redirect()->route('vehicle.index')->with('error',$result['error']);
        } 
    }
}