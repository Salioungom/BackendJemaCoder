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
            $table->unsignedBigInteger('participant_id'); // Déclarez la colonne participant_id ici
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade'); // Ajoutez la clé étrangère ici
            $table->text('description')->nullable();
            $table->string('lien_demo')->nullable();
            $table->string('fichier_supplementaire')->nullable();
            $table->timestamps();
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
