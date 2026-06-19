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
        Schema::create('cashier_corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('user_id')->constrained('users'); // Kasir yang mengajukan
            $table->integer('wrong_quantity'); // Jumlah kuantitas salah sebelumnya
            $table->integer('corrected_quantity'); // Jumlah kuantitas yang benar
            $table->integer('quantity_difference'); // Selisih barang (wrong - corrected)
            $table->decimal('financial_impact', 15, 2); // Nilai finansial kerugian/selisih
            $table->string('reason');
            $table->enum('status', [
                'pending',
                'escalated_to_manager',
                'escalated_to_owner',
                'approved',
                'rejected'
            ])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_corrections');
    }
};
