<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
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

    private function getLinkedIn(){
        return (new LinkedIn('782oyyvd2grwmn', '2oaPD8eTY3pQqVYS'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        $user = $this->linkedInProfil();
        if (is_array($user)){
            $this->storeOrLogin($user);

            $value = session('redirect');
            if ($value){
                return redirect()->route('home');
            }else{
                return redirect()->route($value);
            }
        }else{
            return $user;
        }
    }

    private function linkedInProfil(){
        $linkedIn= $this->getLinkedIn();

        session(['redirect' => 'home']);

        if ($linkedIn->isAuthenticated()) {
            return $linkedIn->get('v1/people/~:(firstName,lastName,email-address,id)');
        }else{
            return Redirect::to($linkedIn->getLoginUrl());
        }
    }

    private function storeOrLogin(array $user){
        $table = DB::table('users')->where('linkedin',$user['id'])->get();

        if (count($table) == 0){
            DB::table('users')->insert([
                'admin' => false,
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
    }

    public function entrepriseView(){
        $linkedin = $this->getLinkedIn();
        if (!$linkedin->isAuthenticated()) {
            session('entreprise.add');
            return redirect()->route('login');
        }

        $linkedin=$linkedin->get('v1/companies?format=json&is-company-admin=true');

        $linkedinEntreprises = [];

        $myEntreprises = DB::table('entreprises')->where('user_id',Auth::id())->orderBy('updated_at','desc')->paginate(9);

        $max = count($myEntreprises);
        foreach($linkedin['values'] as $link){
            $forbidden = false;

            $i = 0;
            while($i < $max){

                if ($myEntreprises[$i]->linkedin_id != $link['id']){
                    $forbidden = true;
                }

                $i++;
            }

            if($forbidden === false){
                $linkedinEntreprises[] = $link;
            }
        }

        return View('entreprises.profil',['linkedinEntreprises' => $linkedinEntreprises,'myEntreprises' => $myEntreprises]);
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('home');
    }
}