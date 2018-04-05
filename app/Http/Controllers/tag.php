<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Cocur\Slugify\Slugify;

class tag extends Controller
{
    public function select(Request $request){

        $tags = DB::table('tags')->get();

        return view('tag',['tags' => $tags]);
    }

    public function store(Request $request){

        $tag = $request->input('tag');


        $slugify = new Slugify();
        $slug = $slugify->slugify($tag,'-');

        $tags = DB::table('tags')->insert([
            'slug' => $slug,
            'tag' => $tag,
        ]);

        return redirect()->route('tagView');
    }

    public function update(Request $request){

        $tag = $request->input('tag');
        $id = $request->input('id');


        $slugify = new Slugify();
        $slug = $slugify->slugify($tag,'-');

        $tags = DB::table('tags')->update([
            'slug' => $slug,
            'id' => $id,
            'tag' => $tag,
        ]);

        return redirect()->route('tagView');
    }

    public function delete(Request $request){
        $id = $request->input('id');

        $tags = DB::table('tags')->delete([
            'id' => $id,
        ]);

        return redirect()->route('tagView');
    }
}
