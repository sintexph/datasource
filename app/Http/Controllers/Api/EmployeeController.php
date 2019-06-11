<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Utilities\EmployeeUtils;
use Illuminate\Support\Facades\Input;
use App\Employee;
use App\Http\Requests\Api\EmployeeStore;
use App\Http\Requests\Api\MultipleEmployeeStore;


class EmployeeController extends Controller
{
    /**
     * Store single employee
     * @return JSON
     */
    public function store(EmployeeStore $request)
    {
        try{

            //return response()->json(!empty($request['bio_ac_numbers']));
            DB::beginTransaction();

            EmployeeUtils::store_employee(
                $request['id_number'],
                $request['first_name'],  
                $request['middle_name'],
                $request['last_name'],
                $request['nick_name'],
                $request['factory'],
                $request['department'],
                $request['section'],
                $request['position'],
                $request['bio_ac_numbers']
            );

            DB::commit();

            return response()->json(['response'=>'success','message'=>'Employee successfully saved!']);

        }catch(\Exception $e)
        {
            DB::rollBack();
            return response()->json(['response'=>'error','message'=>$e->getMessage()]);
        }
    }
    /**
     * Store multiple employees in one time
     * @return JSON
     */
    public function store_multiple(MultipleEmployeeStore $request)
    {
        try{
            
            DB::beginTransaction();

            //return $request['bio_ac_numbers'];
            for($i=0; $i<count($request['id_number']); $i++)
            {
                EmployeeUtils::store_employee(
                    $request['id_number'][$i],
                    $request['first_name'][$i],  
                    $request['middle_name'][$i],
                    $request['last_name'][$i],
                    $request['nick_name'][$i],
                    $request['factory'][$i],
                    $request['department'][$i],
                    $request['section'][$i],
                    $request['position'][$i],
                    $request['bio_ac_numbers'][$request['id_number'][$i]]
                );
            }
            
            DB::commit();

            return response()->json(['response'=>'success','message'=>'Employees successfully saved!']);

        }catch(\Exception $e)
        {
            DB::rollBack();
            return response()->json(['response'=>'error','message'=>$e->getMessage()]);
        }
    }

    /**
     * Store multiple employees that will accept json string as parameter
     */
    public function store_multiple_json(Request $request)
    {
        $this->validate($request,['employees'=>'required']);

        try{
            // decode the json to array
            $employees=json_decode($request['employees']);
            DB::beginTransaction();
            foreach($employees as $employee)
            {
                EmployeeUtils::store_employee(
                    $employee->EmployeeId,
                    $employee->FirstName,
                    $employee->MiddleName,
                    $employee->LastName,
                    $employee->NickName,
                    $employee->Factory,
                    $employee->Department,
                    $employee->Section,
                    $employee->Position,
                    array_map(function($ac){ return $ac->AcNumber;},$employee->BiometricNumbers) //convert the associative array to index arrray
                );
            }
            DB::commit();

            return response()->json(['response'=>'success','message'=>'Employees successfully saved!']);

        }catch(\Exception $e)
        {
            DB::rollBack();
            return response()->json(['response'=>'error','message'=>$e->getMessage()]);
        }
    
    }
    public function find()
    {
        $q=Input::input('q');
        
        if(!empty($q))
        {
            $employees=Employee::where(function($query)use($q){
                $query->orWhere('first_name','like','%'.$q.'%')
                ->orWhere('last_name','like','%'.$q.'%')
                ->orWhere('id_number','like','%'.$q.'%')
                ->orWhereRaw(DB::raw("concat(first_name,' ',last_name) like '%".$q."%'"));
            })->limit(10)->get()->map(function($employee){
                return [
                    'full_name'=>$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name,
                    'first_name'=>$employee->first_name,
                    'middle_name'=>$employee->middle_name,
                    'last_name'=>$employee->last_name,
                    'id_number'=>$employee->id_number,
                    'factory'=>$employee->factory,
                    'department'=>$employee->department,
                    'section'=>$employee->section,
                    'position'=>$employee->position,
                    'date_hired'=>$employee->date_hired,
                    'status'=>$employee->status,
                ];
            });



            return response()->json($employees);
        }
        
        return [];
    }
    
    /**
     * Fetch all employees
     */
    public function fetch_all()
    {
        $q=Input::input('q');
        $factory=Input::input('factory');
        $department=Input::input('department');
        $limit=Input::input('limit');
        $status=Input::input('status');

   
        
        $employees=Employee::on();
        
        if(!empty($q))
        {
            $employees=$employees->where(function($query)use($q){
                $query->orWhere('first_name','like','%'.$q.'%')
                ->orWhere('last_name','like','%'.$q.'%')
                ->orWhere('id_number','like','%'.$q.'%')
                ->orWhereRaw(DB::raw("concat(first_name,' ',last_name) like '%".$q."%'"));
            });
        }
        if(!empty($factory))
            $employees=$employees->where('factory','=',$factory);
        if(!empty($department))
            $employees=$employees->where('department','=',$department);
            
        if($status!=="" && $status!=null)
            $employees=$employees->where('status','=',$status);
        
            

        if(!empty($limit))
        {
            if($limit=='-1')
                $employees=$employees->get();
            else
                $employees=$employees->limit($limit)->get();                

        }else
        {
            $employees=$employees->limit(100)->get();
        }
             
        $employees=$employees->map(function($employee){
                return [
                    'full_name'=>$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name,
                    'first_name'=>$employee->first_name,
                    'middle_name'=>$employee->middle_name,
                    'last_name'=>$employee->last_name,
                    'id_number'=>$employee->id_number,
                    'factory'=>$employee->factory,
                    'department'=>$employee->department,
                    'section'=>$employee->section,
                    'position'=>$employee->position,
                    'date_hired'=>$employee->date_hired,
                    'status'=>$employee->status,
                ];
        });

        return response()->json($employees);
    }
    
}
