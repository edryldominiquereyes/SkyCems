<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventregistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventregisters', function (Blueprint $table) {
            $table->increments('event_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('facility_id')->unsigned();
            $table->foreign('facility_id')->references('facility_id')->on('facility_management')->onDelete('cascade');
            $table->string('organizer');
            $table->string('contact');
            $table->string('reason');
            $table->string('borrow')->nullable();
            $table->string('remark')->nullable();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('status');
            $table->timestamps();
        });

        Schema::rename('eventregisters', 'event_register_detail');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventregisters');
        Schema::dropIfExists('event_register_detail');
    }
}
