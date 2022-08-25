<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('account');
            $table->tinyInteger('accountType', false, true);
            $table->string('companyName')->nullable();
            $table->string('vatNumber')->nullable();
            $table->string('cocNumber')->nullable();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('address');
            $table->smallInteger('streetNumber', false, true);
            $table->string('zipCode', 10);
            $table->string('city');
            $table->string('countryCode', 2);
            $table->string('emailAddress')->unique();
            $table->tinyInteger('unconfirmedEmail', false, true)->nullable();
            $table->tinyInteger('emailAddressValidated', false, true);
            $table->string('phoneNumber');
            $table->string('phoneNumberMobile')->nullable();
            $table->tinyInteger('language', false, true);
            $table->string('emailAddressAbuse')->nullable();
            $table->tinyInteger('newsletter', false, true);
            $table->tinyInteger('agreeToc', false, true);
            $table->tinyInteger('agreeAup', false, true);
            $table->tinyInteger('agreeDpa', false, true);
            $table->tinyInteger('isAllowedFlexMetal', false, true);
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
        Schema::dropIfExists('details');
    }
}
