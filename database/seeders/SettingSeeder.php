<?php

namespace Database\Seeders;
use App\Models\Setting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SettingSeeder extends Seeder{
    public function run(){
        $general = [
            'SITE_TITLE' => 'David Chapo',
            'SITE_TITLE_SF' => 'DC',
            'SITE_URL' => 'https://portal.david-chapo.local',
            'DARK_LOGO' => 'logo.png',
            'LIGHT_LOGO' => 'logo-white.png',
        ];

        foreach($general as $key => $value){
            $id = Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'general',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);

            if($id && ($key == 'DARK_LOGO' || $key == 'LIGHT_LOGO')){
                $file_to_upload = public_path().'/assets/img/logo/';
                if (!File::exists($file_to_upload))
                    File::makeDirectory($file_to_upload, 0777, true, true);

                if(file_exists(public_path('/demo/logo/'.$value)) && !file_exists(public_path('/assets/img/logo/'.$value)) ){
                    File::copy(public_path('/demo/logo/'.$value), public_path('/assets/img/logo/'.$value));
                }
            }
        }

        $social = [
            'FACEBOOK' => 'www.facebook.com/david-chapo',
            'INSTAGRAM' => 'www.instagram.com/david-chapo',
            'YOUTUBE' => 'www.youtube.com/david-chapo',
            'GOOGLE' => 'www.google.com/david-chapo'
        ];

        foreach($social as $key => $value){
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'social',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);
        }
    }
}
