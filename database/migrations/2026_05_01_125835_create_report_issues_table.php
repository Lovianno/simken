<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->text('issue_description')->comment('Deskripsi Kerusakan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_issues');
    }
};