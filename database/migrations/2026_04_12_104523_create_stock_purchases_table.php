<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique(); // Contoh: PO-2026-0001 (Untuk pelacakan)
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Manajer yang mengajukan

            $table->date('purchase_date');
            $table->decimal('total_price', 15, 2)->default(0); // Total uang yang harus dibayar

            // Tambahkan status 'on_delivery' dan 'received' untuk alur logistik gudang
            $table->enum('status', ['pending', 'approved', 'on_delivery', 'received', 'rejected'])->default('pending');

            $table->foreignId('approved_by')->nullable()->constrained('users'); // Owner yang ACC
            $table->foreignId('received_by')->nullable()->constrained('users'); // Pegawai gudang yang verifikasi fisik

            $table->string('invoice_number')->nullable(); // Diisi oleh gudang saat nota fisik supplier datang
            $table->string('invoice_file')->nullable();   // Foto/Scan nota dari supplier
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_purchases');
    }
};
