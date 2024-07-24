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
        Schema::create('soumissions', function (Blueprint $table) {
            $table->id();
            $table->enum('id_type', ['aquipe', 'individuel']);
            $table->unsignedBigInteger('equipe_id')->nullable();
            $table->unsignedBigInteger('individuel_id')->nullable();
            $table->text('description')->nullable();
            $table->string('lien_demo')->nullable();
            $table->string('fichier_supplementaire')->nullable();
            $table->timestamps();
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
            $table->foreign('individuel_id')->references('id')->on('individuels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soumissions');
    }
};
