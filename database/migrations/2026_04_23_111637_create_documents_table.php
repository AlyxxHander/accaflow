<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pengirim
            $table->string('title');
            $table->string('type'); // e.g., 'surat_keterangan', 'magang'
            $table->string('status')->default('submitted'); // submitted, verified, approved, rejected, signed
            $table->string('file_path');
            $table->integer('current_step')->default(1);
            $table->timestamp('sla_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
