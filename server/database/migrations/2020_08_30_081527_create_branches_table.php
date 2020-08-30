<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('repository_id');
            $table->timestamps();

            $table->foreign('repository_id')->references('id')->on('repositories')->cascadeOnDelete();

            $table->unique(['name', 'repository_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
