<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained('parts')->restrictOnDelete();
            $table->enum('type', ['in', 'out'])->comment('Tipe Pergerakan Stok');
            $table->integer('quantity')->comment('Jumlah');
            $table->text('note')->nullable()->comment('Catatan');
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};