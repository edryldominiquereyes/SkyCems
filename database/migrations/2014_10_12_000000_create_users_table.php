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
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('avatar')->default('default.jpg')->nullable();
            $table->string('address')->nullable();
            $table->string('brgy')->nullable();
            $table->string('proofPayment')->nullable();
            $table->string('phone')->unique();
            $table->boolean('status');
            $table->string('role');
            $table->string('terms_and_conditions');
            $table->string('verification_code')->nullable();
            $table->integer('is_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
