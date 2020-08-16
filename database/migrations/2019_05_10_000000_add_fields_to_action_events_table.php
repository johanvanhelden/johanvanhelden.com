<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToActionEventsTable extends Migration
{
    public function up(): void
    {
        Schema::table('action_events', function (Blueprint $table): void {
            $table->text('original')->nullable();
            $table->text('changes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('action_events', function (Blueprint $table): void {
            $table->dropColumn('original', 'changes');
        });
    }
}
