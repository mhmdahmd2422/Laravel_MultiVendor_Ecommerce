<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorShopProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email' , 'vendor@gmail.com')->first();

        $vendor = new Vendor();
        $vendor->name = 'testVendor';
        $vendor->banner = 'uploads/media_64da9979c4b41.jpg';
        $vendor->phone = '12321312';
        $vendor->email = 'vendor@gmail.com';
        $vendor->address = 'Usa';
        $vendor->description = 'shop description';
        $vendor->user_id = $user->id;
        $vendor->status = 1;
        $vendor->save();
    }
}
