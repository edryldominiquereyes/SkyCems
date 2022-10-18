<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->increments('facility_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('facility');
            $table->string('description');
            $table->string('address');
            $table->string('itemList')->nullable();
            $table->string('map')->nullable();
            $table->integer('capacity');
            $table->string('image')->default('default.jpg');
            $table->timestamps();
        });

        Schema::rename('facilities', 'facility_management');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('facility_management');
    }
}
