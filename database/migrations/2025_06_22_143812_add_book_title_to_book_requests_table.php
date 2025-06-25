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
        Schema::table('book_requests', function (Blueprint $table) {
            $table->string('book_title')->after('user_id');
            $table->string('author_name')->nullable()->after('book_title');
            $table->unsignedBigInteger('book_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            $table->dropColumn(['book_title', 'author_name']);
            $table->unsignedBigInteger('book_id')->nullable(false)->change();
        });
    }
};
