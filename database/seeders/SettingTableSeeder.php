<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'id' => 1,
            'name' => 'Toko Selalu Berkah',
            'address' => 'Jl. Raya ciruas pipitan KM.3 Serang Banten',
            'phone_number' => 82194739384,
            'receipt_type' => 1, // kecil
            'discount' => 5,
            'path_logo' => '/img/logo.png',
            'path_member_card' => '/img/member.png',
        ]);
    }
}
