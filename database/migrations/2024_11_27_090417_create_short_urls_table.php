<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->text('original_url');
            $table->string('short_code', 6)->unique();
            $table->integer('click_count')->default(0);
            $table->timestamps();

            $table->index('short_code', 'idx_short_code');
            $table->index('created_at', 'idx_created_at');
        });
    }

    public function down(): void
    {
        Schema::table('short_urls', function (Blueprint $table) {
            $table->dropIndex('idx_short_code');
            $table->dropIndex('idx_created_at');
        });

        Schema::dropIfExists('short_urls');
    }
};


