<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Platform;
use Illuminate\Support\Facades\File;

class PlatformSeeder extends Seeder
{
    public function run(){
        $data = [
            [
                'name' => 'Golden Dragon',
                'description' => 'No one platform all time rock games',
                'backend_url' => '',
                'frontend_url' => 'https://www.playgd.mobi/SSLobby/m4865.0/web-mobile/index.html',
                'logo' => 'golden_dragon.png',
                'image' => ''
            ],
            [
                'name' => 'Orion Stars',
                'description' => 'Choose domination and see what you win',
                'backend_url' => '',
                'frontend_url' => 'http://start.orionstars.vip:8580/',
                'logo' => 'orion_stars.png',
                'image' => ''
            ],
            [
                'name' => 'Fire Phoenix',
                'description' => 'Morethan 78 games with fish table and slot machine',
                'backend_url' => '',
                'frontend_url' => 'https://fpc-mob.com/AD/index.html',
                'logo' => 'fire_phoenix.png',
                'image' => ''
            ],
            [
                'name' => 'Ultda Panda',
                'description' => 'Favourite panda - you know kungfu?',
                'backend_url' => '',
                'frontend_url' => 'https://ht.ultrapanda.mobi/',
                'logo' => 'ultra_panda.png',
                'image' => ''
            ],
            [
                'name' => 'Magic City',
                'description' => 'City full of magic',
                'backend_url' => '',
                'frontend_url' => 'https://www.magiccity777.com/SSLobby/m4880.0/web-mobile/index.html',
                'logo' => 'magic_city.png',
                'image' => ''
            ]
        ];

        foreach($data as $row){
            $id = Platform::insertGetId([
                'name' => $row['name'],
                'description' => $row['description'],
                'backend_url' => $row['backend_url'],
                'frontend_url' => $row['frontend_url'],
                'logo' => $row['logo'],
                'image' => $row['image'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);

            if($id){
                $file_to_upload = public_path().'/uploads/platform/';
                if (!File::exists($file_to_upload))
                    File::makeDirectory($file_to_upload, 0777, true, true);

                if(file_exists(public_path('/demo/platform/'.$row['logo'])) && !file_exists(public_path('/uploads/platform/'.$row['logo'])) ){
                    File::copy(public_path('/demo/platform/'.$row['logo']), public_path('/uploads/platform/'.$row['logo']));
                }
            }
        }
    }
}
