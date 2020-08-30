<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('vendor_id');
            $table->string('repo_name');
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('vendors');
        });
    }

    public function down()
    {
        Schema::dropIfExists('repositories');
    }
}
