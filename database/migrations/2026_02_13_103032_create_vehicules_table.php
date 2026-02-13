<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {

            $table->bigIncrements('id_vehicule');

            $table->unsignedBigInteger('id_chauffeur');

            $table->string('marque', 100)->nullable();
            $table->string('modele', 100)->nullable();
            $table->string('immatriculation', 50)->unique()->nullable();
            $table->string('couleur', 50)->nullable();
            $table->integer('annee')->nullable();
             $table->string('type')->nullable();


            $table->foreign('id_chauffeur')
                  ->references('id_user')
                  ->on('chauffeurs') 
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
