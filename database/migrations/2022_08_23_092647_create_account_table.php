<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId', false, true)->unique();
            $table->string('userName')->unique();
            $table->string('email')->unique();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('gender');
            $table->string('phone');
            $table->tinyInteger('accessLevel', false, true);
            $table->tinyInteger('validateEmail', false, true);
            $table->string('requestIp');
            $table->string('requestIpCountry');
            $table->string('requestIpCountryCode', 2);
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
        Schema::dropIfExists('account');
    }
}
