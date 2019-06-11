<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable=[
        'first_name', 
        'middle_name', 
        'last_name', 
        'nick_name', 
        'id_number', 
        'factory', 
        'department', 
        'section', 
        'position',
        'date_hired',
        'status',
    ];

    public function biometric_numbers()
    {
        return $this->hasMany('App\BiometricNumber','employee_id');
    }
}
