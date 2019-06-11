<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    


Route::middleware('api-authentication')->group(function(){
    
    Route::prefix('employee')->group(function(){
        Route::post('store','Api\EmployeeController@store');
        Route::post('store/multiple','Api\EmployeeController@store_multiple');
        Route::post('store/multiple/json','Api\EmployeeController@store_multiple_json');
        Route::get('find','Api\EmployeeController@find');
        Route::get('fetch_all','Api\EmployeeController@fetch_all');
    });
    
    Route::prefix('factory')->group(function(){
        Route::get('get/all','Api\FactoryController@get_all');
    });

});


Route::prefix('block')->group(function(){
    Route::get('programs','Api\BlockedProgramController@index');
});



#---- TEMPORARY AND WILL BE REMOVED
Route::prefix('fetch')->group(function(){
    
    Route::get('employees/json',function(){
        echo '<pre>';
        return json_encode(\App\Employee::with('biometric_numbers:id,employee_id')->get(), JSON_PRETTY_PRINT);
    });


});
#---- TEMPORARY AND WILL BE REMOVED
