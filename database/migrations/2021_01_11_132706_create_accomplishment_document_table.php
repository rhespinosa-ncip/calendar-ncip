<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomplishmentDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomplishment_document', function (Blueprint $table) {
            $table->id();
            $table->longText('accomplishment');
            $table->longText('remarks');
            $table->unsignedBigInteger('tito_id');
            $table->foreign('tito_id')->references('id')->on('tito');
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
        Schema::dropIfExists('accomplishment_document');
    }
}
