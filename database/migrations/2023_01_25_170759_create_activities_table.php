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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->integer('starva_id');
            $table->string('name');
            $table->float('distance');
            $table->integer('moving_time');
            $table->integer('elapsed_time');
            $table->float('total_elevation_gain');
            $table->string('type');
            $table->string('sport_type');
            $table->dateTime('start_date');
            $table->integer('kudos_count');
            $table->float('average_speed');
            $table->float('max_speed');
            $table->text('description')->nullable();
            $table->integer('calories');
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
        Schema::dropIfExists('activities');
    }
};
