<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->string('status', 30)->default('new')->after('message');
            $table->text('internal_notes')->nullable()->after('ip_address');
        });

        // Migrate existing is_read and replied_at states to status
        DB::table('contact_messages')->whereNotNull('replied_at')->update(['status' => 'replied']);
        DB::table('contact_messages')->whereNull('replied_at')->where('is_read', true)->update(['status' => 'reading']);
        DB::table('contact_messages')->whereNull('replied_at')->where('is_read', false)->update(['status' => 'new']);
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->dropColumn('status');
        });
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->dropColumn('internal_notes');
        });
    }
};
