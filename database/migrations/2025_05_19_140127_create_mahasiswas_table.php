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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); 
            $table->string('nrp')->unique(); 
            
            $table->integer('semester');

            $table->date('tanggal_lahir');
            $table->text('tempat_lahir');
            $table->date('tanggal_masuk');

            $table->enum('status', ['aktif', 'non-aktif', 'cuti'])->default('aktif');

            $table->enum('jenis_kelamin', ['pria', 'wanita']);

            $table->text('alamat');
            $table->string('no_telepon', 15);
            $table->string('asal_sekolah');

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('dosen_wali_id')
                ->constrained('dosens')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('users_id')
                ->constrained('users')
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
        Schema::dropIfExists('mahasiswas');
    }
};