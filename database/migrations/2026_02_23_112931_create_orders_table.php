<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande')->unique();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->decimal('total', 10, 2);
            $table->enum('statut', ['en_attente', 'confirmee', 'livree', 'annulee'])->default('en_attente');
            $table->enum('type_vente', ['en_ligne', 'sur_place'])->default('en_ligne');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};