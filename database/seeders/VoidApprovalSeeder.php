<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transactions;
use App\Models\ApprovalRequest;
use App\Models\User;

class VoidApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        for ($i = 0; $i < 5; $i++) {
            $transaction = Transactions::create([
                'branch_id' => 1,
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . rand(1000, 9999),
                'total_price' => rand(10000, 50000),
            ]);

            ApprovalRequest::create([
                'transaction_id' => $transaction->id,
                'requested_by' => $user->id,
                'type' => 'void',
                'status' => 'pending',
                'reason' => 'Seeder test void'
            ]);
        }
    }
}
