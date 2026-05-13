<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informe_financieros', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('ingresos_totales', 15, 2)->default(0);
            $table->decimal('gastos_totales', 15, 2)->default(0);
            $table->decimal('rentabilidad', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informe_financieros');
    }
};
