<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CreateInHouseCustomer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create inhouse customer for daily inhouse milk consumption
        $customer = Customer::create([
            'name' => 'InHouse Used',
            'customer_type' => 'inhouse',
            'milk' => 0
        ]);
    }
}
