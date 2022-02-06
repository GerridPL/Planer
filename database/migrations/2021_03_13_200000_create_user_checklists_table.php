<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChecklistsTable extends Migration
{
    public function up()
    {
        Schema::create('user_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->string('name', 100);
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('checklist_category');
            $table->unsignedBigInteger('allocated_by');
            $table->unsignedBigInteger('global_checklist');
            $table->unsignedBigInteger('company');
            $table->unsignedBigInteger('file')->nullable();
            $table->longText('user_comment')->nullable();
            $table->char('status', 1)->default(0);
            $table->integer('realization')->default(0);
            $table->date('term')->nullable();
            $table->integer('daysToRealization')->nullable();
            $table->boolean('allowAfterTerm')->default(false);
            $table->date('dateOfRealization')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_checklists');
    }
}
