<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTimeEntriesTable extends Migration
{
    public function up()
    {
        Schema::table('time_entries', function (Blueprint $table) {
            $table->unsignedInteger('work_type_id')->nullable();
            $table->foreign('work_type_id', 'work_type_fk_2319873')->references('id')->on('time_work_types');
            $table->unsignedInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_2457026')->references('id')->on('users');
            $table->unsignedInteger('population_type_id')->nullable();
            $table->foreign('population_type_id', 'population_type_fk_2457126')->references('id')->on('time_population_types');
            $table->unsignedInteger('caseload_type_id')->nullable();
            $table->foreign('caseload_type_id', 'caseload_type_fk_2457127')->references('id')->on('time_caseload_types');
        });
    }
}
