<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique('pages_page_key_unique');
            $table->unique(['page_key', 'section_key'], 'pages_page_section_unique');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique('pages_page_section_unique');
            $table->unique('page_key', 'pages_page_key_unique');
        });
    }
};
