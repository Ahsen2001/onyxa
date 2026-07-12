<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (! Schema::hasColumn('news', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('news', 'short_description')) {
                $table->string('short_description', 500)->nullable()->after('slug');
            }
        });

        if (Schema::hasColumn('news', 'author_id')) {
            DB::table('news')
                ->whereNull('user_id')
                ->whereNotNull('author_id')
                ->update(['user_id' => DB::raw('author_id')]);
        }

        if (Schema::hasColumn('news', 'summary')) {
            DB::table('news')
                ->whereNull('short_description')
                ->whereNotNull('summary')
                ->update(['short_description' => DB::raw('summary')]);
        }

        DB::table('news')->whereNotIn('status', ['draft', 'published'])->update(['status' => 'draft']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE news MODIFY status ENUM('draft', 'published') NOT NULL DEFAULT 'draft'");
        }

        Schema::table('events', function (Blueprint $table) {
            if (! Schema::hasColumn('events', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
        });

        if (Schema::hasColumn('events', 'author_id')) {
            DB::table('events')
                ->whereNull('user_id')
                ->whereNotNull('author_id')
                ->update(['user_id' => DB::raw('author_id')]);
        }

        DB::table('events')->where('status', 'published')->update(['status' => 'upcoming']);
        DB::table('events')->where('status', 'draft')->update(['status' => 'upcoming']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE events MODIFY status ENUM('upcoming', 'completed', 'cancelled') NOT NULL DEFAULT 'upcoming'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE news MODIFY status ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft'");
            DB::statement("ALTER TABLE events MODIFY status ENUM('draft', 'published', 'completed', 'cancelled') NOT NULL DEFAULT 'draft'");
        }
    }
};
