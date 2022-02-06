<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestUsersTable extends Migration
{
    public function up()
    {
        Schema::create('request_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('key')->unique();
            $table->unsignedBigInteger('company');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_users');
    }
}
