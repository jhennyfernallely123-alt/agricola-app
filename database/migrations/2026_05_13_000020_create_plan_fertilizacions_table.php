<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_fertilizacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cultivo_id')->constrained('cultivos')->cascadeOnDelete();
            $table->foreignId('insumo_agricola_id')->constrained('fertilizantes')->cascadeOnDelete();
            $table->foreignId('etapa_fenologica_id')->nullable()->constrained('etapa_fenologicas')->nullOnDelete();
            $table->decimal('dosis', 10, 2)->nullable();
            $table->string('metodo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_fertilizacions');
    }
};
