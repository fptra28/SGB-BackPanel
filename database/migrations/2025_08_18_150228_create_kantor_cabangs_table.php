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
        Schema::create('kantor_cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kantor_cabang', 150);
            $table->text('alamat_kantor_cabang');
            $table->string('fax_kantor_cabang', 50);
            $table->string('telepon_kantor_cabang', 50);
            $table->string('email_kantor_cabang', 100);
            $table->text('maps_kantor_cabang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kantor_cabangs');
    }
};
