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
        Schema::table('approval_requests', function (Blueprint $table) {
            $table->foreignId('transaction_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('requested_by')
                ->constrained('users');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users');

            $table->string('type'); // void
            $table->string('status')->default('pending'); // pending / approved / rejected
            $table->text('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approval_requests', function (Blueprint $table) {
            $table->foreignId('transaction_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('requested_by')
                ->constrained('users');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users');

            $table->string('type'); // void
            $table->string('status')->default('pending'); // pending / approved / rejected
            $table->text('reason')->nullable();
        });
    }
};
