<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTable extends Migration
{
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table): void {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('image');
            $table->string('url')->nullable();
            $table->unsignedInteger('order');

            $table->datetime('publish_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
}
