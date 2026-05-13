<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('variedad')->nullable();
            $table->string('presentacion')->nullable();
            $table->string('lote')->nullable();
            $table->string('calidad')->nullable();
            $table->date('fecha_cosecha')->nullable();
            $table->foreignId('parcela_origen_id')->nullable()->constrained('parcelas')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
