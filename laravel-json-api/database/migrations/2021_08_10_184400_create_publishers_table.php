<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('phone', 100)->unique()->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('website', 50)->unique()->nullable();
            $table->string('address', 255)->nullable();
            $table->tinyInteger('country')->nullable();
            $table->string('logo', 255)->unique()->nullable();
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
        Schema::dropIfExists('publishers');
    }
}
