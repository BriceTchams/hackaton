<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paiement_courses', function (Blueprint $table) {

            $table->bigIncrements('id_paiement');

            $table->unsignedBigInteger('id_course')->unique();

            $table->unsignedBigInteger('id_portefeuille_passager');
            $table->unsignedBigInteger('id_portefeuille_chauffeur');
            $table->unsignedBigInteger('id_portefeuille_admin'); // 👈 AJOUT

            $table->integer('montant_total');
            $table->integer('commission_points');
            $table->integer('montant_chauffeur');

            $table->enum('statut', [
                'En attente',
                'Paye',
                'Echoue',
                'Rembourse'
            ])->default('En attente');

            $table->dateTime('date_paiement')
                  ->default(DB::raw('CURRENT_TIMESTAMP'));

            // 🔑 Foreign Keys

            $table->foreign('id_course')
                ->references('id_course')
                ->on('courses')
                ->cascadeOnDelete();

            $table->foreign('id_portefeuille_passager')
                ->references('id_portefeuille')
                ->on('portefeuilles')
                ->cascadeOnDelete();

            $table->foreign('id_portefeuille_chauffeur')
                ->references('id_portefeuille')
                ->on('portefeuilles')
                ->cascadeOnDelete();

            $table->foreign('id_portefeuille_admin')
                ->references('id_portefeuille')
                ->on('portefeuilles')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiement_courses');
    }
};
