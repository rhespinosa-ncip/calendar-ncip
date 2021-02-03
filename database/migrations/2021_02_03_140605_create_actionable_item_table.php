<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionableItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actionable_item', function (Blueprint $table) {
            $table->id();
            $table->enum('personnel', ['bureau', 'department', 'individual']);
            $table->string('personnel_id');
            $table->string('actionable_item');
            $table->dateTime('deadline', 0);
            $table->unsignedBigInteger('meeting_schedule_id');
            $table->foreign('meeting_schedule_id')->references('id')->on('meeting_schedule');
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
        Schema::dropIfExists('actionable_item');
    }
}
