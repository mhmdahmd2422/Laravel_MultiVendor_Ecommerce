<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSetting::create([
            'site_name' => 'SAZAO',
            'layout' => 'LTR',
            'contact_email' => 'admin@gmail.com',
            'currency_name' => 'USD',
            'currency_icon' => '$',
            'timezone' => 'Asia/Riyadh',
        ]);
    }
}
