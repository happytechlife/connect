<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCommunity extends Controller
{
    static public function add(){
        return view('admin.community.add');
    }

    static public function addRequest(Request $request){
        $name = $request->input('name');

        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        $description = $request->input('description');

        $slugify = new Slugify();
        $slug = $slugify->slugify($name, '-');

        DB::table('community')->insert([
            'name' => $name,
            'slug' => $slug,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'description' => $description
        ]);

        return redirect()->route('admin.communities');
    }

    static public function edit($slug){
        $community =  DB::table('community')->where('slug',$slug)->first();

        if (is_null($community)){
            abort(404);
            return null;
        }


        return view('admin.community.edit',['community' => $community]);
    }

    static public function editRequest($slug,Request $request){
        $name = $request->input('name');

        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        $description = $request->input('description');

        $slugify = new Slugify();
        $newSlug = $slugify->slugify($name, '-');

        DB::table('community')->where('slug',$slug)->update([
            'name' => $name,
            'slug' => $newSlug,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'description' => $description
        ]);

        return redirect()->route('admin.communities');
    }

    static public function delete($slug){
        DB::table('community')->where('slug',$slug)->delete();

        return redirect()->route('admin.communities');
    }
}
