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
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('hackaton_id');
            $table->enum('status', ['en attente', 'accepté', 'refusé']);
            $table->integer('Nbre_membre')->nullable();
            $table->timestamps();

            // Clé étrangère
            $table->foreign('hackaton_id')->references('id')->on('hackathons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipes');
    }
};
