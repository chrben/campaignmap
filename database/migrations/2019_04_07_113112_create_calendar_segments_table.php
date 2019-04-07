<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_segments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('calendar_id', false, true);
            $table->integer('length', false, true);
            $table->integer('index', false, true);
            $table->boolean('is_holiday')->default(false);
            $table->integer('every_nth', false, true)->nullable()->default(null);
            $table->string('name');
            $table->string('alt_name')->nullable()->default(null);
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
        Schema::dropIfExists('calendar_segments');
    }
}
