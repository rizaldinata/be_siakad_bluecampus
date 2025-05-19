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
        Schema::create('frs_mahasiswas', function (Blueprint $table) {
            $table->id();

            $table->enum('status_disetujui', ['ya', 'tidak', 'ditolak']);

            $table->text('catatan');

            $table->foreignId('mahasiswa_id')
                ->constrained('mahasiswas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('frs_id')
                ->constrained('frs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frs_mahasiswas');
    }
};