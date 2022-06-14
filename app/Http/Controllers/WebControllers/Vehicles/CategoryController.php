<?php

namespace App\Http\Controllers\WebControllers\Vehicles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Vehicles\CategoryService;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    //local service vars
    protected $categoryService;
    //constructor
    public function __construct(CategoryService $categoryService)
	{
        $this->middleware('auth');
		$this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('category.create');
        
    }
    //get list by ajax onload 
    public function getList()
    {
        // return JSON-formatted response
        $categories = $this->categoryService->all(['*'],['Vehicles']);
        $data['categories'] = $categories;

        $data_result = [];
        $counter = 1;
        foreach ($categories as $category)
        {
            $edit_btn = "";
            //check if category has child record in vehicles table
            if($category->vehicles->count() <=0 )
                $edit_btn = "<a class='dt-button buttons-delete buttons-html5' onclick=\"return confirm('Are you sure?')\" href='".route('category-delete', $category->id)."'><i>Delete</i></a>";
            else
                $edit_btn = $category->vehicles->count()." vehicle(s)";
            $data = [
                'no'         => $counter,
                'name'       => $category->name,
                'edit_btn'   => "<a class='dt-button buttons-copy buttons-html5' href='".route('category.edit', ['category' => $category->id])."'><i>Edit</i></a>",
                'del_btn'    => $edit_btn
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
            'name'             => 'required|string|Max:250',  
        ]);
        //check validation
        if ($validator->fails())
        {
            return redirect()->route('vehicle.index')->with('error',$validator->messages());       
        }
        
        $data = getRequestData($request->only($this->categoryService->fillables()));
       
        $result = ['status' => 200];
        DB::beginTransaction();
        try{
            $result['data']   = $this->categoryService->create($data); 
            DB::commit();
            return redirect()->route('category.index')->with('message','Category added successfully');
           
        } catch(Exception $e){
            DB::rollBack();
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  
            return redirect()->route('category.index')->with('error',$result['error']);
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
        $category = $this->categoryService->show($id);
        if(!$category)
            die('Invalid Request');    
        $data = [];
        $data['category'] = $category;

        return view('category.edit',$data);
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
            'name'             => 'required|string|Max:250'     
        ]);
        //check validation
        if ($validator->fails())
        {
            return redirect()->route('category.edit',$id)->with('error',$validator->messages());       
        }
        $data = getRequestData($request->only($this->categoryService->fillables()));
        try{
            $result['data'] = $this->categoryService->update($data,$id); 
            return redirect()->route('category.index',$id)->with('message','Vehicle category updated successfully');
        } catch(Exception $e){
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  

            return redirect()->route('category.edit',$id)->with('error',$result['error']);
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
        $category = $this->categoryService->show($id,['*'],['Vehicles']);
        if(!$category)
            return redirect()->route('category.index')->with('error','Invalid request');
        else if($category->vehicles->count()>0)
            return redirect()->route('category.index')->with('error','This category has vehicle records');
        //remove records from database
        $result = ['status' => 200];
        try{
            $result['data'] = $this->categoryService->deleteCategory($id); 
            return redirect()->route('category.index',$id)->with('message','Category deleted successfully');
        } catch(Exception $e){
            $result = ['status' => 500,
                        'error'=> $e->getMessage()
                    ];  
            return redirect()->route('category.index')->with('error',$result['error']);
        } 
    }
}