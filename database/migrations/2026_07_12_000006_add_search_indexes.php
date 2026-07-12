<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->index(['status', 'availability']);
            $table->index('name');
        });

        Schema::table('news', function (Blueprint $table): void {
            $table->index(['status', 'published_at']);
            $table->index('title');
        });

        Schema::table('events', function (Blueprint $table): void {
            $table->index(['status', 'event_date']);
            $table->index('title');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropIndex(['status', 'availability']);
            $table->dropIndex(['name']);
        });

        Schema::table('news', function (Blueprint $table): void {
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['title']);
        });

        Schema::table('events', function (Blueprint $table): void {
            $table->dropIndex(['status', 'event_date']);
            $table->dropIndex(['title']);
        });
    }
};
