<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class IndexController extends Controller
{
    /**
     * Show the index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('index');
    }

    public function generate(Request $request){
        $data = [   
            'link' => base64_encode(random_bytes(20)),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => auth()->user()->id
        ];

        $id = Link::insertGetId($data);
        
        if($id){
            $url = __settings('SITE_FRONT_URL').'/link/'.$data['link'];
            return response()->json(['message' => 'Link generated successfully', 'status' => 'success', 'link' => $url], 200);
        }else{
            return response()->json(['message' => 'Something went wrong.', 'status' => 'error'], 201);
        }
    }
}
