<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_issue_id')->constrained('report_issues')->cascadeOnDelete();
            $table->foreignId('part_id')->constrained('parts')->restrictOnDelete();
            $table->integer('quantity')->default(1)->comment('Jumlah Onderdil');
            $table->decimal('unit_price', 15, 2)->default(0)->comment('Harga Satuan');
            $table->decimal('total_price', 15, 2)->default(0)->comment('Total Harga');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_items');
    }
};