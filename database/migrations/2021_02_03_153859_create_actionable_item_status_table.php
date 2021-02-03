<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionableItemStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actionable_item_status', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->unsignedBigInteger('actionable_item_id');
            $table->foreign('actionable_item_id')->references('id')->on('actionable_item');
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
        Schema::dropIfExists('actionable_item_status');
    }
}
