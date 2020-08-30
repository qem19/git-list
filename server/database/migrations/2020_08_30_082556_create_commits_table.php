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
            $table->unsignedInteger('branch_id');
            $table->string('description');
            $table->string('author');
            $table->timestamp('committed_at');
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
            $table->unique(['sha', 'branch_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commits');
    }
}
