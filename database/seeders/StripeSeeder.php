<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stripe;

class StripeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(){
        $data = [
            [
                'email' => 'hardiik3697@gmail.com',
                'publishable_key' => 'pk_test_51Qr2WDJiEuPGANeX4wOktoGLnc93AsefRCQGHEId4OL3R9gldUcLEJF3oALC5fgs33S5dopuupBjiI35HyUyvU2v00ibdqZlSv',
                'secret_key' => 'sk_test_51Qr2WDJiEuPGANeXHQT04s6Sg0dBxTUcC3UwzsFcDWrmMVF8Hpzyw0pduEURu35fw8886ISSfPcRHGQYMraiB1Uz00zxx3uEk9'
            ]
        ];
        
        foreach($data as $row){
            $id = Stripe::insertGetId([
                'email' => $row['email'],
                'publishable_key' => $row['publishable_key'],
                'secret_key' => $row['secret_key'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);  
        }
    }
}
