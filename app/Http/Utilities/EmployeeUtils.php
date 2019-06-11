<?php

namespace App\Http\Utilities;
use Illuminate\Http\Request;
use App\Employee;
use App\BiometricNumber;

class EmployeeUtils 
{
    public static function store_employee($id_number,$first_name,$middle_name,$last_name,$nick_name,$factory,$department,$section,$position,$biometric_numbers=[])
    {
        
        $employee=Employee::firstOrNew([
                'id_number'=>$id_number
        ]);
        $employee->first_name=strtoupper($first_name);  
        $employee->middle_name=strtoupper($middle_name);
        $employee->last_name=strtoupper($last_name);
        $employee->nick_name=strtoupper($nick_name);
        $employee->factory=strtoupper($factory);
        $employee->department=strtoupper($department);
        $employee->section=strtoupper($section);
        $employee->position=strtoupper($position);
        $employee->save();

        
        // Save the biometrics numbers of the employee
        if(!empty($biometric_numbers))
        {
            foreach($biometric_numbers as $bioac)
            {
                $bio=BiometricNumber::firstOrNew([
                    'employee_id'=>$employee->id,
                    'ac_number'=>$bioac
                ]);
                $bio->save();
            }
        }
        

        return true;
    }
}
