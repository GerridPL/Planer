<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPointsTable extends Migration
{
    public function up()
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->integer('subIndex')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->boolean('skiped')->default(false);
            $table->boolean('active')->default(false);
            $table->longText('description');
            $table->unsignedBigInteger('user_checklist');
            $table->unsignedBigInteger('company');
            $table->unsignedBigInteger('user_point')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_points');
    }
}
