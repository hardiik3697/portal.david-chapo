<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * index
     */
    public function index(Request $request, $param = null){
        if($param == null){
            $param = 'general';
        }

        $tabs = Setting::select('type')->distinct()->get()->toArray();
        $data = Setting::select('id', 'key', 'value')->where(['type' => $param])->get();
        
        return view('setting.index', ['data' => $data, 'tabs' => $tabs, 'param' => $param]);
    }

    /** 
     * update
     */
    public function update(Request $request){
        $data = $request->all();
        unset($data['_method']);
        unset($data['_token']);
        $param = $data['param'];
        unset($data['param']);
        session(['param' => $param]);

        if(!empty($data)){
            foreach($data as $key => $value){
                $collection = Setting::where(['id' => $key])->first();
                if(!empty($collection)){
                    $collection->value = $value;
                    $collection->save();
                }
            }
        }
        
        return redirect()->back()->with(['success' => 'Settings updated successfully', 'param' => $param]);
    }
}
