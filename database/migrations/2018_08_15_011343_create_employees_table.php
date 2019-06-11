<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('nick_name');
            $table->string('id_number')->unique();
            $table->string('factory');
            $table->string('department');
            $table->string('section');
            $table->string('position');
            $table->string('date_hired');
            $table->string('status')->comment('Status of the employee whether he/she is resigned or active
                                                Active=1
                                                Resigned=0');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
