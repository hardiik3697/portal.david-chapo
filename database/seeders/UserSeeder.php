<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder{

    public function run(){
        $data = [
            [
                'name' => 'Mitul Gajjar',
                'phone' => '9879879871',
                'username' => 'mitulgajjar',
                'email' => 'mitul-chapo@yopmail.com'
            ],
            [
                'name' => 'Hardik Patel',
                'phone' => '9879879873',
                'username' => 'hardikpatel',
                'email' => 'hardik-chapo@yopmail.com'
            ]
        ];
        
        foreach($data as $row){
            $user = User::create([
                'name' => $row['name'],
                'phone' => $row['phone'],
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => bcrypt('Admin@123'),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);        
        }

        // $file_to_upload = public_path().'/uploads/users/';
        // if (!File::exists($file_to_upload))
        //     File::makeDirectory($file_to_upload, 0777, true, true);

        // if(file_exists(public_path('/assets/images/users/profile-pic.jpg')) && !file_exists(public_path('/uploads/users/user-icon.jpg')) ){
        //     File::copy(public_path('/assets/images/users/profile-pic.jpg'), public_path('/uploads/users/user-icon.jpg'));
        // }
    }
}