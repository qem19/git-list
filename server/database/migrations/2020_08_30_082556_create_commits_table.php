<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitsTable extends Migration
{
    public function up()
    {
        Schema::create('commits', function (Blueprint $table) {
            $table->id();
            $table->string('branch');
            $table->unsignedInteger('repository_id');
            $table->string('description');
            $table->timestamps();

            $table->foreign('repository_id')->references('id')->on('repositories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('commits');
    }
}
