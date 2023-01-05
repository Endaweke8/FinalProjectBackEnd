<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->string('section');
            $table->string('email');
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('studentts');
    }
};
