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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('inventaris_id')->nullable();
            $table->string('barang');
            $table->string('type')->nullable();
            $table->bigInteger('serial_number');
            $table->string('spesifikasi')->nullable();
            $table->enum('status', ['Baik','Rusak', 'Tidak Dipakai', 'Dilelang'])->default('Baik');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('department', ['Technology', 'Marketing', 'Finance'])->default('Technology');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
