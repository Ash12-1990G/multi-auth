<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->date('admission');
            $table->string('phone');
            $table->date('birth');
            $table->string('gender');
            $table->string('alt_phone')->nullable();
            $table->string('father_name');
            $table->string('image')->nullable();
            $table->string('address1');
            $table->string('city1');
            $table->string('state1');
            $table->string('pincode1');
            $table->string('address2');
            $table->string('city2');
            $table->string('state2');
            $table->string('pincode2');
            $table->string('status')->default('1');
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
        Schema::dropIfExists('students');
    }
}
