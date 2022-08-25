<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMd5HashFieldToApilogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apilog', function (Blueprint $table) {
            $table->string('md5_hash')->unique()->after('response');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apilog', function (Blueprint $table) {
            $table->removeColumn('md5_hash');
        });
    }
}
