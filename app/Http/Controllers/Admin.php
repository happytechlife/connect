<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admin extends Controller
{
    public function __construct()
    {
        //$this->middleware('Admin');
    }

    public static function community(){
        $communities = DB::table('community')->paginate(15);

        return View('admin.community.list',['communities' => $communities]);
    }

    public static function tags(){
        $tags = DB::table('tags')->paginate(50);

        return View('admin.tags.list',['tags' => $tags]);
    }
}
