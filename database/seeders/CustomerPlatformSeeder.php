<?php

namespace Database\Seeders;
use App\Models\CustomerPlatform;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CustomerPlatformSeeder extends Seeder{

    public function run(){
        $data = [
            [
                'customer_id' => '1',
                'platform_id' => '1',
                'username' => 'mitul_gd'
            ],
            [
                'customer_id' => '1',
                'platform_id' => '2',
                'username' => 'mitul_os'
            ],
            [
                'customer_id' => '1',
                'platform_id' => '3',
                'username' => 'mitul_fp'
            ],
            [
                'customer_id' => '1',
                'platform_id' => '4',
                'username' => 'mitul_up'
            ],
            [
                'customer_id' => '1',
                'platform_id' => '5',
                'username' => 'mitul_mc'
            ],
            [
                'customer_id' => '2',
                'platform_id' => '1',
                'username' => 'hardik_gd'
            ],
            [
                'customer_id' => '2',
                'platform_id' => '2',
                'username' => 'hardik_os'
            ],
            [
                'customer_id' => '2',
                'platform_id' => '3',
                'username' => 'hardik_fp'
            ],
            [
                'customer_id' => '2',
                'platform_id' => '4',
                'username' => 'hardik_up'
            ],
            [
                'customer_id' => '3',
                'platform_id' => '1',
                'username' => 'kiran_gd'
            ],
            [
                'customer_id' => '3',
                'platform_id' => '2',
                'username' => 'kiran_os'
            ],
            [
                'customer_id' => '3',
                'platform_id' => '3',
                'username' => 'kiran_fp'
            ],
            [
                'customer_id' => '4',
                'platform_id' => '1',
                'username' => 'sani_gd'
            ],
            [
                'customer_id' => '4',
                'platform_id' => '2',
                'username' => 'sani_os'
            ],
            [
                'customer_id' => '5',
                'platform_id' => '1',
                'username' => 'jaydeep_gd'
            ]
        ];
        
        foreach($data as $row){
            $customer = CustomerPlatform::create([
                'customer_id' => $row['customer_id'],
                'platform_id' => $row['platform_id'],
                'username' => $row['username'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);        
        }
    }
}