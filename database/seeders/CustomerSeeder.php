<?php

namespace Database\Seeders;
use App\Models\Customer;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CustomerSeeder extends Seeder{

    public function run(){
        $data = [
            [
                'name' => 'Mitul Gajjar',
                'phone' => '9879879871',
                'email' => 'mitul-chapo@yopmail.com'
            ],
            [
                'name' => 'Hardik Patel',
                'phone' => '9879879872',
                'email' => 'hardik-chapo@yopmail.com'
            ],
            [
                'name' => 'Kiran Patel',
                'phone' => '9879879873',
                'email' => 'kiran-chapo@yopmail.com'
            ],
            [
                'name' => 'Sani Patel',
                'phone' => '9879879874',
                'email' => 'sani-chapo@yopmail.com'
            ],
            [
                'name' => 'Jaydeep Patel',
                'phone' => '9879879875',
                'email' => 'jaydeep-chapo@yopmail.com'
            ],
            [
                'name' => 'Jeehal Patel',
                'phone' => '9879879876',
                'email' => 'jeehal-chapo@yopmail.com'
            ]
        ];
        
        foreach($data as $row){
            $customer = Customer::create([
                'name' => $row['name'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'stripe_id' => 2,
                'stripe_customer_id' => '',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);        
        }
    }
}