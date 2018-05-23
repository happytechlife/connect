<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTags extends Controller
{
    public function add(){
        return view('admin.tags.add');
    }

    public function addRequest(Request $request){
        $tag = $request->input('tag');

        $description = $request->input('description');


        $slugify = new Slugify();
        $slug = $slugify->slugify($tag,'-');

        DB::table('tags')->insert([
            'slug' => $slug,
            'tag' => $tag,
            'description' => $description,
        ]);

        return redirect()->route('admin.tags');
    }

    public function edit($slug){
        $tag = DB::table('tags')->where('slug',$slug)->first();

        if (is_null($tag)){
            abort(404);
            return null;
        }

        return view('admin.tags.edit',['tag' => $tag]);
    }

    public function editRequest($slug,Request $request){

        $tag = $request->input('tag');

        $slugify = new Slugify();
        $newSlug = $slugify->slugify($tag,'-');

        $tag = DB::table('tags')->where('slug',$slug)->update([
            'slug' => $newSlug,
            'tag' => $tag,
        ]);

        return redirect()->route('admin.tags');
    }

    public function delete($id){
        DB::table('tags_link')->where('id_tag',$id)->delete();

        DB::table('tags')->delete([
            'id' => $id,
        ]);

        return redirect()->route('admin.tags');
    }
}
