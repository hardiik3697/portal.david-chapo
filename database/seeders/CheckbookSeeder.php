<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Checkbook;

class CheckbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(){
        $data = [
            [
                'email' => 'hardiik3697@gmail.com',
                'publishable_key' => '934abf9cd34345dca2eef0ef1817d183',
                'secret_key' => 'FyhINNSkB04LVuhLHOtR5edjwmdF93'
            ]
        ];
        
        foreach($data as $row){
            $id = Checkbook::insertGetId([
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
