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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('nip')->unique();
            $table->string('no_telp');
            $table->string('alamat');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();

            $table->enum('jenis_kelamin', ['pria', 'wanita']);

            $table->string('program_studi');

            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};