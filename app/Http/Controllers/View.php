<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class View extends Controller
{
    public static function home(){

        $communities = DB::table('community')->get();
        $tags = DB::table('tags')->get();

        return view('home',['communities' => $communities,'tags' => $tags]);
    }

    public static function community($slug){
        $community = DB::table('community')->where('slug',$slug)->first();

        if (is_null($community)){
            abort(404);
            return null;
        }

        $entreprises = DB::table('entreprises')->where('community',$community->id)->get();

        return view('community.view',['community'=> $community,'entreprises'=> $entreprises]);
    }

    public function entreprise($slug){
        $entreprise = Db::table('entreprises')->where('slug',$slug)->first();
        if (!$entreprise){
            abort(404);
            return null;
        }

        return View('entreprise.view',['entreprise' => $entreprise]);
    }

    public static function tag($slug){
        $tag = DB::table('tags')->where('slug',$slug)->first();

        if (is_null($tag)){
            abort(404);
            return null;
        }

        $entreprises = DB::table('tags_link')->where('id_tag',$tag->id)->join('entreprises', 'tags_link.id_entreprise', '=', 'entreprises.id')->get();

        $id_communities = [];
        $i = 0;
        $max = count($entreprises);
        while($i < $max){
            $id_communities[] = $entreprises[$i]->community;

            $i++;
        }
        $id_communities = array_unique($id_communities);

        $communities = DB::table('community')->whereIn('id',$id_communities)->get();

        return view('tags.view',['tag'=> $tag,'entreprises' => $entreprises,'communities' => $communities]);
    }
}
