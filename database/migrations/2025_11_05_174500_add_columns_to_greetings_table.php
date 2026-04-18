<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('greetings', function (Blueprint $table) {
            $table->string('section_name')->default('Sambutan')->after('id');
            $table->string('title')->after('section_name');
            $table->string('subtitle')->nullable()->after('title');
            $table->text('content')->after('subtitle');
            $table->string('image')->nullable()->after('content');
            $table->string('person_name')->nullable()->after('image');
            $table->string('person_title')->nullable()->after('person_name');
            $table->integer('order')->default(0)->after('person_title');
            $table->boolean('is_active')->default(true)->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('greetings', function (Blueprint $table) {
            $table->dropColumn([
                'section_name',
                'title',
                'subtitle',
                'content',
                'image',
                'person_name',
                'person_title',
                'order',
                'is_active'
            ]);
        });
    }
};
