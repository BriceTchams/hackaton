<?php use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portefeuilles', function (Blueprint $table) {

            $table->bigIncrements('id_portefeuille');
            // $table->integer('id_user');

          $table->foreignId('user_id')
        ->unique()
        ->constrained('users')
        ->cascadeOnDelete();

            $table->integer('solde_points')->default(0);

            $table->dateTime('date_derniere_maj')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portefeuilles');
    }
};
