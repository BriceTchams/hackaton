<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('login_otps', function (Blueprint $table) {
      $table->id();
      // $table->unsignedBigInteger('user_id');
      $table->foreignId('user_id')->constrained();
      $table->string('code_hash');
      $table->timestamp('expires_at'); // date d'expiration 
      $table->unsignedSmallInteger('attempts')->default(0); // pour le nombre de tentative 
      $table->boolean('used')->default(false); // precise si le code a deja ete utiliser ou pas .
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('login_otps');
  }
};