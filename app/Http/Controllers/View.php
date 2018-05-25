<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class View extends Controller
{
    public static function home(){

        $communities = DB::table('community')->get();

        return view('home',['communities' => $communities]);
    }

    public static function community($slug){
        $community = DB::table('community')->where('slug',$slug)->first();

        if (is_null($community)){
            abort(404);
            return null;
        }

        return view('community.view',['community'=> $community]);
    }

    public static function tag($slug){
        $tag = DB::table('tags')->where('slug',$slug)->first();

        if (is_null($tag)){
            abort(404);
            return null;
        }

        return view('tags.view',['tag'=> $tag]);
    }
}
