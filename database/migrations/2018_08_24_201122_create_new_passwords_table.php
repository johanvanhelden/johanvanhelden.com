<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPasswordsTable extends Migration
{
    public function up(): void
    {
        Schema::create('new_passwords', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->index();

            $table->string('token')->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::drop('new_passwords');
    }
}
