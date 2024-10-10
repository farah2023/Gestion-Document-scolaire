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
        Schema::create('partenaire', function (Blueprint $table) {
            $table->id();
            $table->string('nom_par');
            $table->string('prenom_par');
            $table->string('password');
            $table->string('ville');
            $table->string('email');
            $table->string('photo_par')->nullable();
            $table->string('nbr_experience');
            $table->string('domaine_expertise');
            $table->integer('connexion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partenaire');
    }
};
