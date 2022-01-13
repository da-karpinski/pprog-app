<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->integer('manufacturer_id');
            $table->string('model', 50);
            $table->string('model_short', 20);
            $table->integer('system_id');
            $table->string('screen_size', 10);
            $table->integer('battery');
            $table->integer('rear_camera_quantity');
            $table->integer('processor_id');
            $table->string('ram_size', 5);
            $table->string('storage_size', 10);
            $table->boolean('has_nfc');
            $table->boolean('has_5g');
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
        Schema::dropIfExists('phones');
    }
}
