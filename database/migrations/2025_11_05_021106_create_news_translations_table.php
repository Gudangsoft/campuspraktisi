<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('news_translations')) {
            Schema::create('news_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('news_id')->constrained()->onDelete('cascade');
                $table->string('locale', 2)->index();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('excerpt')->nullable();
                $table->longText('content');
                $table->timestamps();
                
                $table->unique(['news_id', 'locale']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('news_translations');
    }
};
