<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Entreprise extends Controller
{
    public function index(){

        $entreprises = DB::table('entreprises')->get();

        $tags_entreprises = DB::table('tags_link')->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('entreprises');
        })->get();
        $communautes = DB::table('community')->get();
        $tags = DB::table('tags')->get();

        return View('entreprise.list',['entreprises' => $entreprises,'communautes' => $communautes,'tags' => $tags,'tags_entreprises' => $tags_entreprises]);
    }

    public function update(Request $request){

        $description = $request->input('description');
        $community = $request->input('community');
        $name = $request->input('name');
        $id = $request->input('id');
        $tagsList = explode(',',$request->input('tagList'));

        DB::table('tags_link')->where('id_entreprise',$id)->delete();

        $insert = [];

        foreach($tagsList as $idTag){

            if (!is_null($request->input('tag_'.$idTag))){
                $insert[] = [
                    'id_entreprise' => $id,
                    'id_tag' => $idTag,
                ];
            }
        }

        $slugify = new Slugify();
        $slug = $slugify->slugify($name, '-');

        DB::table('tags_link')->insert($insert);
        DB::table('entreprises')->where('id',$id)->update([
            'community' => $community,
            'slug' => $slug,
            'description' => $description,
            'name' => $name,
        ]);

        return redirect()->route('entreprises');
    }

    public function delete(Request $request){
        $id = $request->input('id');

        DB::table('entreprises')->where('id',$id)->delete($id);
        DB::table('tags_link')->where('id_entreprise',$id)->delete($id);

        return redirect()->route('entreprises');
    }

    public function store(Request $request){

        $description = $request->input('description');
        $community = $request->input('community');
        $name = $request->input('name');

        $slugify = new Slugify();
        $slug = $slugify->slugify($name, '-');

        $tagsList = explode(',',$request->input('tagList'));

        DB::table('entreprises')->insert([
            'community' => $community,
            'slug' => $slug,
            'description' => $description,
            'name' => $name,
        ]);

        $id = DB::getPdo()->lastInsertId();

        $insert = [];
        foreach($tagsList as $idTag){
            if (!is_null($request->input('tag_'.$idTag))){
                $insert[] = [
                    'id_entreprise' => $id,
                    'id_tag' => $idTag,
                ];
            }
        }

        DB::table('tags_link')->insert($insert);

        return redirect()->route('entreprises');
    }

    public function view(Request $request,$slug)
    {
        $entreprise = DB::table('entreprises')->where('slug',$slug)->first();

        return View('entreprise.view',['entreprise' => $entreprise]);
    }
}
