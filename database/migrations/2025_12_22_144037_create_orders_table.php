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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->datetime('tanggal_order');
            $table->integer('total_harga');
            $table->enum('status_pembayaran', ['pending', 'success', 'failed'])->default('pending');
            $table->enum('metode_pembayaran', ['qris', 'e_walet', 'cash', 'free',])->nulable;
            $table->string('email_pemesan');
            $table->string('nomor_telepon');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
