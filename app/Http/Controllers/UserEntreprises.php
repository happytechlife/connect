<?php

namespace App\Http\Controllers;

use Happyr\LinkedIn\LinkedIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserEntreprises extends Controller
{
    public function __construct()
    {
        //return $this->middleware('Auth');
    }

    public function get(){

    }

    public function add(){
        $linkedIn=new LinkedIn('86dvcmdnpjqfew', 'go15zYDt4rtyvdb5');
        if ($linkedIn->isAuthenticated()) {
            $company =$linkedIn->get('v1/companies?format=json&is-company-admin=true');
            dd($company);
        }else{
            dd('failed');
        }
    }

    public function store(Request $request){

    }
}
