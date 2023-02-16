<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('attedance_id')->nullable();
            $table->string('wrk_emp_code')->nullable();
            $table->string('cln_id')->nullable();
            $table->string('cln_email')->nullable();
            $table->string('rt_status')->nullable();
            $table->integer('cln_rating')->nullable();
            $table->string('cln_description')->nullable();
            $table->date('rqt_date')->nullable();
            $table->date('rt_date')->nullable();
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->time('total_work')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('rqt_emp_code')->nullable();
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
        Schema::dropIfExists('weekly_ratings');
    }
}
