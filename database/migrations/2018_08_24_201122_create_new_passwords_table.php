<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Creates a new passwords table.
 */
class CreateNewPasswordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('new_passwords', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('new_passwords');
    }
}
