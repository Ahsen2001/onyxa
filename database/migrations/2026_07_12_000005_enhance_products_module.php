<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->string('meta_keywords', 500)->nullable()->after('meta_description');
            $table->string('og_title')->nullable()->after('meta_keywords');
            $table->string('og_description', 500)->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('canonical_url')->nullable()->after('og_image');
            $table->string('robots')->default('index, follow')->after('canonical_url');
        });

        Schema::create('product_tags', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->unique(['product_id', 'slug']);
            $table->index('slug');
        });

        Schema::create('product_specifications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('spec_key');
            $table->string('spec_value');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'sort_order']);
        });

        Schema::create('product_related', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_product_id')->constrained('products')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'related_product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_related');
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_tags');

        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn([
                'meta_keywords',
                'og_title',
                'og_description',
                'og_image',
                'canonical_url',
                'robots',
            ]);
        });
    }
};
