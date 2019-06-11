<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiometricNumber extends Model
{
    protected $fillable=['employee_id','ac_number'];
}
