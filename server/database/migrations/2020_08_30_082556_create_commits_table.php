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
            $table->string('sha');
            $table->unsignedInteger('repository_id');
            $table->text('description');
            $table->string('author');
            $table->timestamp('committed_at');
            $table->timestamps();

            $table->foreign('repository_id')->references('id')->on('repositories')->cascadeOnDelete();
            $table->unique(['sha', 'repository_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commits');
    }
}
