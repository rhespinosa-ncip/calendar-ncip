<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('zoom_meeting_description');
            $table->dateTime('date', 0);
            $table->enum('participant', ['bureau', 'department']);
            $table->enum('is_participant', ['yes', 'no']);
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('meeting_schedule');
    }
}
