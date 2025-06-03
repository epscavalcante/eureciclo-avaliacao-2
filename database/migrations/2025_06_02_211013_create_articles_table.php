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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->string('identificacao')->nullable(true);
            $table->string('data')->nullable(true);
            $table->text('ementa')->nullable(true);
            $table->text('titulo')->nullable(true);
            $table->text('subtitulo')->nullable(true);
            $table->longText('texto')->nullable(true);
            $table->json('metadata')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
