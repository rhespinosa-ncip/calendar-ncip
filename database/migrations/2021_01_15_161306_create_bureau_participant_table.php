<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBureauParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureau_participant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meeting_schedule_id');
            $table->foreign('meeting_schedule_id')->references('id')->on('meeting_schedule');
            $table->unsignedBigInteger('bureau_id');
            $table->foreign('bureau_id')->references('id')->on('bureau');
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
        Schema::dropIfExists('bureau_participant');
    }
}
