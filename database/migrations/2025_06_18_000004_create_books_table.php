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
        Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('title_en')->nullable();
    $table->string('slug')->nullable();
    $table->text('description')->nullable();
    $table->text('description_en')->nullable();
    $table->string('isbn')->nullable();
    $table->string('publisher')->nullable();
    $table->date('publication_date')->nullable();
    $table->integer('pages')->nullable();
    $table->string('language')->default('ar');
    $table->string('cover_image')->nullable();
    $table->integer('quantity')->default(1);
    $table->integer('available_quantity')->default(1);
    $table->enum('status', ['available', 'borrowed', 'maintenance','active','inactive'])->default('available');

    // 👇 مرة واحدة فقط
    $table->unsignedBigInteger('category_id');
    $table->unsignedBigInteger('author_id');

    //$table->boolean('is_active')->default(true);
    $table->timestamps();

    // المفاتيح الأجنبية
    $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
  });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
