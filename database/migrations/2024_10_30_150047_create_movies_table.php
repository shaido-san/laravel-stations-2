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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 700)->unique(); // 映画タイトル (string型に変更しunique指定)
            $table->text('image_url')->nullable(); // 画像URL
            $table->integer('published_year')->default(2000); // 公開年
            $table->boolean('is_showing')->default(false); // 上映中かどうか
            $table->text('description')->nullable(); // 映画の説明
            
            // ジャンルIDを外部キーとして設定
            $table->unsignedbigInteger('genre_id')->nullable(); // genre_id
            
            // 外部キー制約
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};