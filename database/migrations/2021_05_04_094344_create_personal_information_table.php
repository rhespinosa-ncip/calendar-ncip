<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name_extension');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->enum('sex', ['male', 'female']);
            $table->enum('civil_status', ['single', 'married', 'widowed', 'separated']);
            $table->string('height');
            $table->string('weight');
            $table->enum('blood_type', ['a+', 'a-', 'b+', 'b-', 'o+', 'o-', 'ab+', 'ab-']);
            $table->string('gsis_no');
            $table->string('pag_ibig_no');
            $table->string('philhealth_no');
            $table->string('sss_no');
            $table->string('tin_no');
            $table->string('agency_employee_no');

            $table->enum('filipino', ['yes', 'no']);
            $table->enum('dual_citizenship', ['yes', 'no']);
            $table->enum('dual_citizenship_status', ['by_birth', 'by_naturalization'])->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->unsigned();
            $table->foreign('country_id')->references('id')->on('country');

            $table->string('telephone_no');
            $table->string('mobile_no');

            $table->string('spouce_surname')->nullable();
            $table->string('spouce_first_name')->nullable();
            $table->string('spouce_middle_name')->nullable();
            $table->string('spouce_name_extension')->nullable();
            $table->string('spouce_occupation')->nullable();
            $table->string('spouce_employer')->nullable();
            $table->string('spouce_address')->nullable();
            $table->string('spouce_telephone')->nullable();

            $table->string('father_surname');
            $table->string('father_first_name');
            $table->string('father_middle_name');
            $table->string('father_name_extension');

            $table->string('mother_surname');
            $table->string('mother_first_name');
            $table->string('mother_middle_name');

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
        Schema::dropIfExists('personal_information');
    }
}
