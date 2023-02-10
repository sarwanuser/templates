<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->nullable();
            $table->string('project_url')->nullable();
            $table->string('project_dev_url')->nullable();
            $table->string('client')->nullable();
            $table->string('working_emp')->nullable();
            $table->string('budget')->nullable();
            $table->date('created_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('timeline')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('status_change_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('target_status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
