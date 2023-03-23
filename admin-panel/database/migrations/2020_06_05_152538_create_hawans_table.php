<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hawans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ID');
            $table->bigInteger('user_id');
            $table->string('rashid_number');
            $table->string('yazman_name');
            $table->string('date_of_hawan');
            $table->string('country_code');
            $table->string('state');
            $table->string('distric');
            $table->string('block');
            $table->string('ward_house_number');
            $table->string('status');
            $table->string('created_at');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hawans');
    }
}