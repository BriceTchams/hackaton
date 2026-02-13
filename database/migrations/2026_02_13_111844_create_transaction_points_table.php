<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaction_points', function (Blueprint $table) {
            $table->bigIncrements('id_trans');

            $table->unsignedBigInteger('id_portefeuille');

            $table->enum('type_mouv', [
                'Recharge', 'Paiement', 'Commission', 'Bonus', 'Remboursement'
            ]);
            $table->integer('montant');

            $table->integer('valeur_points');
            $table->dateTime('date_heure')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('id_portefeuille')
                ->references('id_portefeuille')->on('portefeuilles')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_points');
    }
};
