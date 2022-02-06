<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('tax_number', 10)->unique();
            $table->string('city', 50);
            $table->string('postcode', 6);
            $table->date('sub_exp_date')->default(date("Y.m.d"));
            $table->string('email');
            $table->string('phone', 9);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
