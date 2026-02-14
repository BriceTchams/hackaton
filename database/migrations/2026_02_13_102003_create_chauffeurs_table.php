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
        Schema::create('chauffeurs', function (Blueprint $table) {
             $table->foreignId('id_user')
                  ->primary()
                  ->constrained('users') 
                  ->cascadeOnDelete();

            $table->string('numero_permis', 50);
                        $table->string('ville')->nullable();

            $table->string('photo_piece_identite');

            $table->decimal('latitude', 10, 7)->nullable();
            //comments
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('statut_validation', [
                'En attente',
                'Valide',
                'Bloque'
            ])->default('En attente'); //brice
            $table->string('etat');

            $table->decimal('note_moyenne', 3, 2)->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chauffeurs');
    }
};
