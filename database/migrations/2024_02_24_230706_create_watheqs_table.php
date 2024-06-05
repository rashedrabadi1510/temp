<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatheqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watheqs', function (Blueprint $table) {
            $table->id();
            $table->String('user_id');
            $table->String('commerical_regestration');
            $table->String('company_name');
            $table->String('ceEntityNumber');
            $table->String('job_type');
            $table->String('release_date');
            $table->String('expire_date');
            $table->String('email');
            $table->String('phone_number');
            $table->string('company_address');
            $table->string('verfired');
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
        Schema::dropIfExists('watheqs');
    }
}
