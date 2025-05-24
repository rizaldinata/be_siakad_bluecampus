<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('frs', function (Blueprint $table) {
            $table->id();
            
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat']);

            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->integer('semester');

            $table->string('kelas');

            $table->foreignId('paket_frs_id')
                ->constrained('paket_frs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('matkul_id')
                ->constrained('mata_kuliahs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('dosen_id')
                ->constrained('dosens')
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
        Schema::dropIfExists('frs');
    }
};