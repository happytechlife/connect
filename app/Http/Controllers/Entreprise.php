<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Entreprise extends Controller
{
    public function index(){

        $entreprises = DB::table('entreprises')->get();
        $communautes = DB::table('community')->get();

        return View('entreprise.list',['entreprises' => $entreprises,'communautes' => $communautes]);
    }

    public function update(Request $request){

        $description = $request->input('description');
        $community = $request->input('community');
        $name = $request->input('name');
        $id = $request->input('id');

        $slugify = new Slugify();
        $slug = $slugify->slugify($name, '-');

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

        DB::table('entreprises')->delete([$id]);

        return redirect()->route('entreprises');
    }

    public function store(Request $request){

        $description = $request->input('description');
        $community = $request->input('community');
        $name = $request->input('name');

        $slugify = new Slugify();
        $slug = $slugify->slugify($name, '-');

        DB::table('entreprises')->insert([
            'community' => $community,
            'slug' => $slug,
            'description' => $description,
            'name' => $name,
        ]);

        return redirect()->route('entreprises');
    }

    public function view(Request $request,$slug)
    {
        $entreprise = DB::table('entreprises')->where('slug',$slug)->first();

        return View('entreprise.view',['entreprise' => $entreprise]);
    }
}
