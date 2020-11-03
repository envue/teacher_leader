<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeWorkTypesTable extends Migration
{
    public function up()
    {
        Schema::create('time_work_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('color')->nullable();
            $table->boolean('use_population_type')->default(0)->nullable();
            $table->boolean('use_caseload_type')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
