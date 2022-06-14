<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->comment('categories table id set as foreign key');
            $table->string('color', 250)->comment('Vehicle color');
            $table->string('model', 250)->comment('Vehicle model e.g. Toyota');
            $table->string('make', 250)->comment('Vehicle Make');
            $table->string('registration_no', 250)->comment('Vehicle Registration Number');
            $table->timestamps();

            //set foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
