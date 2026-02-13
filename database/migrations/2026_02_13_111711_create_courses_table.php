<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id_course');

            $table->unsignedBigInteger('id_passager');
            $table->unsignedBigInteger('id_chauffeur');

            $table->string('lieu_depart', 255)->nullable();
            $table->string('lieu_dest', 255)->nullable();
            $table->text('coordonnees_gps')->nullable();

            $table->dateTime('heure_demande')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('heure_fin')->nullable();

            $table->enum('statut_course', ['Cherche', 'En cours', 'Terminee', 'Annulee'])
                  ->default('Cherche');

            $table->integer('prix_en_points')->nullable();

            $table->foreign('id_passager')
                ->references('id_user')->on('passagers')
                ->cascadeOnDelete();

            $table->foreign('id_chauffeur')
                ->references('id_user')->on('chauffeurs')
                ->cascadeOnDelete();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
