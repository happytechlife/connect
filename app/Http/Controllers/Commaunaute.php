<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Commaunaute extends Controller
{
    public function index()
    {
        $communautes = DB::table('community')->get();

        return View('communaute.list', ['communautes' => $communautes]);
    }

    public function store(Request $request)
    {
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

        return redirect()->route('communities');
    }

    public function update(Request $request)
    {
        $name = $request->input('name');
        $id = $request->input('id');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        $description = $request->input('description');

        $slugify = new Slugify();
        $slug = $slugify->slugify($name, '-');

        DB::table('community')->where('id', $id)->update([
            'name' => $name,
            'slug' => $slug,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'description' => $description
        ]);

        return redirect()->route('communities');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        DB::table('community')->delete([
            'id' => $id,
        ]);

        return redirect()->route('communities');
    }

    public function view(Request $request,$slug)
    {
        $communaute = DB::table('community')->where('slug',$slug)->first();

        return View('communaute.view',['communaute' => $communaute]);
    }
}
