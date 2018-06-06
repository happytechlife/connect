<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminCommunity extends Controller
{
    public function __construct()
    {
       // $this->middleware('Admin');
    }

    static public function add(){
        return view('admin.community.add');
    }

    static public function addRequest(Request $request){
        $name = $request->input('name');

        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        $description = strip_tags($request->input('description'),'<strong><a><i>');

        $file = $request->file('picture');
        if (!$file){
            return redirect()->back()->withInput($request->all());
        }

        $slugify = new Slugify();
        $slug = $slugify->slugify($name, '-');

        $file_name = $slug.'.'.$file->getClientOriginalExtension();

        $content = file_get_contents($request->file('picture')->getRealPath());
        Storage::makeDirectory('public/community/big/');
        Storage::makeDirectory('public/community/small/');
        Storage::put('public/community/big/'.$file_name, $content);

        $img = imagecreatefromstring($content);
        $new = imagecreatetruecolor(20,20);

        $taille = array(imagesx($img), imagesy($img));
        $coef = min($taille[0] / 20, $taille[1] / 20);
        $deltax = $taille[0] - ($coef * 20);
        $deltay = $taille[1] - ($coef * 20);

        imagecopyresampled($new, $img, 0, 0, $deltax / 2, $deltay / 2, 20, 20, $taille[0] - $deltax, $taille[1] - $deltay);
        ob_start();
            imagejpeg($new,null,100);
        $content = ob_get_clean();
        Storage::put('public/community/small/'.$file_name, $content);

        DB::table('community')->insert([
            'name' => $name,
            'slug' => $slug,
            'file_name' => $file_name,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'description' => $description
        ]);

        return redirect()->route('admin.communities');
    }

    static public function edit($slug){
        $community =  DB::table('community')->where('slug',$slug)->first();

        if (is_null($community)){
            abort(204);
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

        $update = [
            'name' => $name,
            'slug' => $newSlug,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'description' => $description
        ];

        $file = $request->file('picture');

        if ($file or $slug != $newSlug){
            $info = DB::table('community')->where('slug',$slug)->first();


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

        DB::table('community')->where('slug',$slug)->update($update);

        if (isset($oldFileName) and array_key_exists('file_name',$update)){
            if ($file){
                Storage::delete('public/community/big/'.$oldFileName);
                Storage::delete('public/community/small/'.$oldFileName);

                $content = file_get_contents($request->file('picture')->getRealPath());
                Storage::put('public/community/big/'.$update['file_name'], $content);

                $img = imagecreatefromstring($content);
                $new = imagecreatetruecolor(20,20);

                $taille = array(imagesx($img), imagesy($img));
                $coef = min($taille[0] / 20, $taille[1] / 20);
                $deltax = $taille[0] - ($coef * 20);
                $deltay = $taille[1] - ($coef * 20);

                imagecopyresampled($new, $img, 0, 0, $deltax / 2, $deltay / 2, 20, 20, $taille[0] - $deltax, $taille[1] - $deltay);
                ob_start();
                imagejpeg($new,null,100);
                $content = ob_get_clean();


                Storage::put('public/community/small/'.$update['file_name'], $content);
            }else{
                Storage::move('public/community/small/'.$oldFileName, 'public/community/small/'.$update['file_name']);
                Storage::move('public/community/big/'.$oldFileName, 'public/community/big/'.$update['file_name']);
            }
        }

        return redirect()->route('admin.communities');
    }

    static public function delete($slug){
        $info = DB::table('community')->where('slug',$slug)->first();

        if (!$info){
            return redirect()->back();
        }

        Storage::delete('public/community/big/'.$info->file_name);
        Storage::delete('public/community/small/'.$info->file_name);

        DB::table('community')->where('slug',$slug)->delete();

        return redirect()->route('admin.communities');
    }
}
