<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_level', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('level');
            $table->string('name_of_school')->nullable();
            $table->string('basic_education')->nullable();

            $table->date('attendance_to')->nullable();
            $table->date('attendance_from')->nullable();

            $table->string('highest_level')->nullable();
            $table->string('year_graduated')->nullable();
            $table->string('scholarship')->nullable();

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
        Schema::dropIfExists('education_level');
    }
}
