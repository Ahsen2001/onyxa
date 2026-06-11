<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (! Schema::hasColumn('galleries', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if (! Schema::hasColumn('pages', 'section_key')) {
                $table->string('section_key', 100)->nullable()->after('page_key');
            }

            if (! Schema::hasColumn('pages', 'image')) {
                $table->string('image')->nullable()->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'description')) {
                $table->dropColumn('description');
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'section_key')) {
                $table->dropColumn('section_key');
            }

            if (Schema::hasColumn('pages', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
