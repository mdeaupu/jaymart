<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT. Sumber Makmur Logistik',
                'email' => 'sales@sumbermakmur.com',
                'phone' => '081234567890',
                'address' => 'Jl. Kawasan Industri No. 12, Jakarta',
            ],
            [
                'name' => 'CV. Jaya ATK & Kertas',
                'email' => 'admin@jayapaper.co.id',
                'phone' => '085711223344',
                'address' => 'Gudang Hijau Blok C, Bekasi',
            ],
            [
                'name' => 'Distributor Tinta Nusantara',
                'email' => 'contact@tintanusantara.com',
                'phone' => '081399887766',
                'address' => 'Sentra Bisnis Daan Mogot, Tangerang',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
