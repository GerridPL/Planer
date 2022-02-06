<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Keys extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('company')->references('id')->on('companies');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('company')->references('id')->on('companies');
        });
        Schema::table('global_checklists', function (Blueprint $table) {
            $table->foreign('checklist_category')->references('id')->on('categories');
            $table->foreign('author')->references('id')->on('users');
            $table->foreign('company')->references('id')->on('companies');
        });
        Schema::table('global_points', function (Blueprint $table) {
            $table->foreign('checklist')->references('id')->on('global_checklists');
            $table->foreign('point')->references('id')->on('global_points');
            $table->foreign('company')->references('id')->on('companies');
        });
        Schema::table('user_checklists', function (Blueprint $table) {
            $table->foreign('user')->references('id')->on('users');
            $table->foreign('allocated_by')->references('id')->on('users');
            $table->foreign('global_checklist')->references('id')->on('global_checklists');
            $table->foreign('company')->references('id')->on('companies');
            $table->foreign('file')->references('id')->on('files');
        });
        Schema::table('user_points', function (Blueprint $table) {
            $table->foreign('user_checklist')->references('id')->on('user_checklists');
            $table->foreign('user_point')->references('id')->on('user_points');
        });
    }

    public function down()
    {
        //
    }
}
