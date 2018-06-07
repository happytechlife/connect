<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminTags extends Controller
{
    public function __construct()
    {
        $this->middleware('Admin');
    }

    public function add(){
        return view('admin.tags.add');
    }

    public function addRequest(Request $request){

        $file = $request->file('picture');
        if (!$file){
            return redirect()->back()->withInput($request->all());
        }

        $tag = $request->input('tag');

        $description = $request->input('description');

        $slugify = new Slugify();
        $slug = $slugify->slugify($tag,'-');

        $file_name = $slug.'.'.$file->getClientOriginalExtension();

        $content = file_get_contents($request->file('picture')->getRealPath());
        Storage::makeDirectory('public/tag/');
        Storage::put('public/tag/'.$file_name, $content);


        DB::table('tags')->insert([
            'slug' => $slug,
            'tag' => $tag,
            'file_name' => $file_name,
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
        $name = $request->input('tag');
        $description = $request->input('description');

        $slugify = new Slugify();
        $newSlug = $slugify->slugify($tag,'-');

        $update = [
            'tag' => $name,
            'slug' => $newSlug,
            'description' => $description
        ];

        $file = $request->file('picture');

        if ($file or $slug != $newSlug){
            $info = DB::table('tags')->where('slug',$slug)->first();


            if (!$info){
                return redirect()->back();
            }

            $oldFileName = $info->file_name;

            if ($file){
                $update['file_name'] = $newSlug.'.'.$file->getClientOriginalExtension();
            }else{

                $pos = (strrpos($oldFileName,'.') - strlen($oldFileName));

                $update['file_name'] = $newSlug.substr($oldFileName,$pos);
            }
        }

        DB::table('tags')->where('slug',$slug)->update($update);

        if (isset($oldFileName) and array_key_exists('file_name',$update)){
            if ($file){
                Storage::delete('public/tag/'.$oldFileName);

                $content = file_get_contents($request->file('picture')->getRealPath());
                Storage::put('public/tag/'.$update['file_name'], $content);
            }else{
                Storage::move('public/tag/'.$oldFileName, 'public/tag/'.$update['file_name']);
            }
        }

        return redirect()->route('admin.tags');
    }

    public function delete($id){
        $info = DB::table('tags')->where('id',$id)->first();

        if (!$info){
            return redirect()->back();
        }

        Storage::delete('public/tag/'.$info->file_name);

        DB::table('tags_link')->where('id_tag',$id)->delete();

        DB::table('tags')->delete([
            'id' => $id,
        ]);

        return redirect()->route('admin.tags');
    }
}
