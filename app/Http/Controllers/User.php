<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Socialite;
use Happyr\LinkedIn\LinkedIn as LinkedIn;

class User extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['login','linkedin']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){

        $linkedIn=new LinkedIn('86dvcmdnpjqfew', 'go15zYDt4rtyvdb5');

        if ($linkedIn->isAuthenticated()) {
            //we know that the user is authenticated now. Start query the API

            $user=$linkedIn->get('v1/people/~:(firstName,lastName,email-address,id)');

            return $this->storeOrLogin($user);
        }elseif ($linkedIn->hasError()) {
            return redirect()->route('home');
        }else{
            return Redirect::to($linkedIn->getLoginUrl());
        }
    }

    private function storeOrLogin(array $user){
        $table = DB::table('users')->where('linkedin',$user['id'])->get();

        if (count($table) == 0){
            DB::table('users')->insert([
               'linkedin' => $user['id'],
               'lastName' => $user['firstName'],
               'firstName' => $user['lastName'],
               'email' => $user['emailAddress'],
            ]);

            $id = intval(DB::getPdo()->lastInsertId());
        }else{
            $id = $table[0]->id;

            DB::table('users')->update([
                'linkedin' => $user['id'],
                'lastName' => $user['firstName'],
                'firstName' => $user['lastName'],
                'email' => $user['emailAddress'],
            ]);
        }

        Auth::loginUsingId($id,true);

        return redirect()->route('home');
    }
}
