<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {

            $table->foreignId('id_user')
                  ->primary()
                  ->constrained('users') 
                  ->cascadeOnDelete();

            $table->enum('niveau_acces', [
                'SuperAdmin',
                'Support',
                'Moderateur'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
