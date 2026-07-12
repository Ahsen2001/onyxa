<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            if (! Schema::hasIndex('products', ['status', 'created_at'])) {
                $table->index(['status', 'created_at']);
            }

            if (! Schema::hasIndex('products', ['status', 'is_featured'])) {
                $table->index(['status', 'is_featured']);
            }
        });

        Schema::table('contact_messages', function (Blueprint $table): void {
            if (! Schema::hasIndex('contact_messages', ['status', 'created_at'])) {
                $table->index(['status', 'created_at']);
            }

            if (! Schema::hasIndex('contact_messages', ['created_at'])) {
                $table->index('created_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            if (Schema::hasIndex('contact_messages', ['status', 'created_at'])) {
                $table->dropIndex(['status', 'created_at']);
            }

            if (Schema::hasIndex('contact_messages', ['created_at'])) {
                $table->dropIndex(['created_at']);
            }
        });

        Schema::table('products', function (Blueprint $table): void {
            if (Schema::hasIndex('products', ['status', 'created_at'])) {
                $table->dropIndex(['status', 'created_at']);
            }

            if (Schema::hasIndex('products', ['status', 'is_featured'])) {
                $table->dropIndex(['status', 'is_featured']);
            }
        });
    }
};
