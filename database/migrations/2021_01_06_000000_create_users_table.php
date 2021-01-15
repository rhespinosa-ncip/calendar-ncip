<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('position');
            $table->string('username');
            $table->string('password');
            $table->unsignedBigInteger('department_id')->nullable()->unsigned();
            $table->foreign('department_id')->references('id')->on('department');
            $table->unsignedBigInteger('bureau_id')->nullable()->unsigned();
            $table->foreign('bureau_id')->references('id')->on('bureau');
            $table->enum('user_type', ['admin', 'user', 'head']);
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
        Schema::dropIfExists('users');
    }
}
