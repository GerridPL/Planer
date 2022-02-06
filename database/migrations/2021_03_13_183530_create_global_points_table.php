<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalPointsTable extends Migration
{
    public function up()
    {
        Schema::create('global_points', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->integer('subIndex')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->longText('description');
            $table->unsignedBigInteger('checklist');
            $table->unsignedBigInteger('company');
            $table->unsignedBigInteger('point')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('global_points');
    }
}
