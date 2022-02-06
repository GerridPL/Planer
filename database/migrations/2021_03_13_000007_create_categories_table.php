<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('company');
            $table->timestamps();
            $table->boolean('deactivated')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
