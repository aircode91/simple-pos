<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::create([
            'code' => 00001,
            'name' => 'member-1',
            'address' => 'Jl. entah kemana',
            'phone_number' => 8646927349
        ]);
    }
}
