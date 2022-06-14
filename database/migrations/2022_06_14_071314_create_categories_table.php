<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',250)->comment('Category name of cars e.g. SUV etc')->nullable();
            $table->timestamps();
        });

        // Insert some categories
        $data = [
            [
                'name' => 'Bus'
            ],
            [
                'name' => 'Sudan'
            ],
            [
                'name' => 'SUV'
            ],
            [
                'name' => 'Hatchback'
            ]
        ];
        DB::table('categories')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
