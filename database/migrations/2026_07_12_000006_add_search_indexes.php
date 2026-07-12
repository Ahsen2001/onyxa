<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            if (! Schema::hasIndex('products', ['status', 'availability'])) {
                $table->index(['status', 'availability']);
            }

            if (! Schema::hasIndex('products', ['name'])) {
                $table->index('name');
            }
        });

        Schema::table('news', function (Blueprint $table): void {
            if (! Schema::hasIndex('news', ['status', 'published_at'])) {
                $table->index(['status', 'published_at']);
            }

            if (! Schema::hasIndex('news', ['title'])) {
                $table->index('title');
            }
        });

        Schema::table('events', function (Blueprint $table): void {
            if (! Schema::hasIndex('events', ['status', 'event_date'])) {
                $table->index(['status', 'event_date']);
            }

            if (! Schema::hasIndex('events', ['title'])) {
                $table->index('title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            if (Schema::hasIndex('products', ['status', 'availability'])) {
                $table->dropIndex(['status', 'availability']);
            }

            if (Schema::hasIndex('products', ['name'])) {
                $table->dropIndex(['name']);
            }
        });

        Schema::table('news', function (Blueprint $table): void {
            if (Schema::hasIndex('news', ['status', 'published_at'])) {
                $table->dropIndex(['status', 'published_at']);
            }

            if (Schema::hasIndex('news', ['title'])) {
                $table->dropIndex(['title']);
            }
        });

        Schema::table('events', function (Blueprint $table): void {
            if (Schema::hasIndex('events', ['status', 'event_date'])) {
                $table->dropIndex(['status', 'event_date']);
            }

            if (Schema::hasIndex('events', ['title'])) {
                $table->dropIndex(['title']);
            }
        });
    }
};
