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
        Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // --- Campi comuni ---
        $table->text('bio')->nullable();
        $table->string('phone')->nullable();
        $table->string('website_url')->nullable();

        // --- Campi specifici per il CANDIDATO ---
        $table->string('cv_path')->nullable(); // Percorso del PDF
        $table->string('github_url')->nullable();
        $table->string('linkedin_url')->nullable();

        // --- Campi specifici per l'AZIENDA (Employer) ---
        $table->string('company_name')->nullable();
        $table->string('vat_number', 20)->nullable(); // Partita IVA
        $table->string('logo_path')->nullable(); // Logo aziendale
        $table->string('address')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
