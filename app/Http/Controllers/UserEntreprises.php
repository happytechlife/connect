<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Happyr\LinkedIn\LinkedIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserEntreprises extends Controller
{

    private function getLinkedIn()
    {
        return (new LinkedIn('782oyyvd2grwmn', '2oaPD8eTY3pQqVYS'));
    }

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'linkedin']]);
    }

    public function add($id)
    {

        $linkedin = $this->getLinkedIn();

        $myEntreprises = $linkedin->get('v1/companies?format=json&is-company-admin=true');

        $allow = false;

        $i = 0;
        $max = count($myEntreprises['_total']);
        while ($i < $max) {

            if ($myEntreprises['values'][$i]['id'] == $id) {
                $allow = true;
                break;
            }

            $i++;
        }

        if ($allow === false) {
            return Redirect()->route('entreprise.profil');
        }

        $values = [
            'email' => Input::old('email'),
            'description' => Input::old('description'),
            'name' => Input::old('name'),
            'tags' => Input::old('tags'),
            'community' => Input::old('community'),
            'twitter_url' => Input::old('twitter_url'),
            'facebook_url' => Input::old('facebook_url'),
        ];

        if (!$values['description']) {
            $entreprise = $linkedin->get('v1/companies/' . $id . ':(id,name,description)?format=json');
        } else {
            $entreprise = $linkedin->get('v1/companies/' . $id . ':(id,name)?format=json');
        }

        if (!$values['name']) {
            $values['name'] = $entreprise['name'];
        }
        if (!$values['description']) {
            $values['description'] = $entreprise['description'];
        }
        if (!$values['email']) {
            $values['email'] = Auth::user()->email;
        }

        if ($values['community']) {
            $community = $values['community'];
            $communitiesBDD = DB::table('community')
                ->whereExists(function ($query) use ($community) {
                    $query->select(
                        DB::raw(1))
                        ->from('community')
                        ->where('id', $community);
                })
                ->orWhereExists(function ($query) use ($community) {
                    $query->select(
                        DB::raw(1))
                        ->from('community')
                        //TODO ->whereNot('id', $community)
                        ->inRandomOrder()->limit(4);
                })
                ->get();
        } else {
            $communitiesBDD = DB::table('community')->inRandomOrder()->limit(5)->get();
        }

        $i = 0;
        $max = count($communitiesBDD);
        $communities = [];
        while ($i < $max) {
            $communities[] = '{
                id: ' . $communitiesBDD[$i]->id . ',
                name: "' . str_replace('"', '\"', $communitiesBDD[$i]->name) . '"
            }';
            $i++;
        }
        $communities = join(',', $communities);

        if ($values['tags']) {
            $split = array_filter(array_map('intval', explode(',', $values['tags'])), 'is_numeric');

            if (count($split) < 5) {
                $tagsBDD = DB::table('tags')
                    ->whereExists(function ($query) use ($split) {
                        $query->select(
                            DB::raw(1))
                            ->from('tags')
                            ->whereIn('id', $split);
                    })
                    ->orWhereExists(function ($query) use ($split) {
                        $query->select(
                            DB::raw(1))
                            ->from('tags')
                            // TODO ->whereNotIn('id', $split)
                            ->inRandomOrder()->limit(5 - count($split));
                    })
                    ->get();
            } else {
                $tagsBDD = DB::table('tags')->whereIn('id', $split)->get();
            }
        } else {
            $tagsBDD = DB::table('tags')->inRandomOrder()->limit(5)->get();
        }

        $i = 0;
        $max = count($tagsBDD);
        $tags = [];
        while ($i < $max) {
            $tags[] = '{
                id: ' . $tagsBDD[$i]->id . ',
                tag: "' . str_replace('"', '\"', $tagsBDD[$i]->tag) . '"
            }';
            $i++;
        }
        $tags = join(',', $tags);

        return View('entreprises.add', ['values' => $values, 'entreprise' => $entreprise, 'tags' => $tags, 'communities' => $communities, 'id' => $id]);
    }

    public function edit($slug)
    {
        $entreprise = DB::table('entreprises')->where('slug', $slug)->where('user_id', Auth::id())->first();

        if (!$entreprise) {
            return Redirect()->back();
        }

        $values = [
            'email' => Input::old('email'),
            'description' => Input::old('description'),
            'name' => Input::old('name'),
            'tags' => Input::old('tags'),
            'community' => Input::old('community'),
            'twitter_url' => Input::old('twitter_url'),
            'facebook_url' => Input::old('facebook_url'),
        ];

        if (!$values['email']) {
            $values['email'] = $entreprise->email;
        }
        if (!$values['description']) {
            $values['description'] = $entreprise->description;
        }
        if (!$values['name']) {
            $values['name'] = $entreprise->name;
        }

        if (!$values['community']) {
            $values['community'] = $entreprise->community;
        }
        if (!$values['twitter_url']) {
            $values['twitter_url'] = $entreprise->twitter;
        }
        if (!$values['facebook_url']) {
            $values['facebook_url'] = $entreprise->facebook;
        }

        $tagsBDD = DB::table('tags')
            ->whereExists(function ($query) use ($entreprise) {
                $query->select(
                    DB::raw(1))
                    ->from('tags_link')
                    ->where('id_entreprise', $entreprise->id);
            })->get();


        $tagsID = [];
        $i = 0;
        $max = count($tagsBDD);
        $tags = [];
        while ($i < $max) {
            $tags[] = '{
                id: ' . $tagsBDD[$i]->id . ',
                tag: "' . str_replace('"', '\"', $tagsBDD[$i]->tag) . '"
            }';
            $tagsID[] = $tagsBDD[$i]->id;
            $i++;
        }

        if (count($tagsBDD) < 5) {
            $tagsBDD = DB::table('tags')->inRandomOrder()->limit(count($tagsBDD) - 5)->get();

            $i = 0;
            $max = count($tagsBDD);
            $tags = [];
            while ($i < $max) {
                $tags[] = '{
                    id: ' . $tagsBDD[$i]->id . ',
                    tag: "' . str_replace('"', '\"', $tagsBDD[$i]->tag) . '"
                }';
                $i++;
            }
        }

        $tags = join(',', $tags);
        $values['tags'] = join('-', $tagsID);

        $communitiesBDD = DB::table('community')
            ->whereExists(function ($query) use ($entreprise) {
                $query->select(
                    DB::raw(1))
                    ->from('community')
                    ->orWhere('id', '<>', $entreprise->community)
                    ->inRandomOrder()->limit(4);
            })
            ->orWhereExists(function ($query) use ($entreprise) {
                $query->select(
                    DB::raw(1))
                    ->from('community')
                    ->orWhere('id', $entreprise->community);
            })
            ->distinct()
            ->get();

        $i = 0;
        $max = count($communitiesBDD);
        $communities = [];
        while ($i < $max) {
            $communities[] = '{
                id: ' . $communitiesBDD[$i]->id . ',
                name: "' . str_replace('"', '\"', $communitiesBDD[$i]->name) . '"
            }';
            $i++;
        }
        $communities = join(',', $communities);

        return View('entreprises.edit', ['values' => $values, 'tags' => $tags, 'communities' => $communities, 'entreprise' => $entreprise]);
    }

    public function addStore($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'name' => 'required|min:10|max:60',
            'email' => 'email|required',
            'tags' => 'nullable',
            'community' => 'integer',
            'twitter_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return Redirect()->back()->withInput($request->all())->withErrors($validator);
        }


        $description = $request->get('description');
        $name = $request->get('name');
        $email = $request->get('email');
        $tags = $request->get('tags');
        $community = $request->get('community');
        $twitter = $request->input('twitter_url');
        $facebook = $request->input('facebook_url');

        $slugify = new Slugify();
        $slug = $slugify->slugify($name, '-');

        $linkedin = $this->getLinkedIn();

        $myEntreprises = $linkedin->get('v1/companies?format=json&is-company-admin=true');

        $allow = false;

        $i = 0;
        $max = count($myEntreprises['_total']);
        while ($i < $max) {

            if ($myEntreprises['values'][$i]['id'] == $id) {

                $allow = true;
                break;
            }

            $i++;
        }

        if ($allow === false) {
            return Redirect()->route('entreprise.profil');
        }

        $file = $request->file('picture');
        if (!$file) {
            return redirect()->back()->withInput($request->all());
        }

        $file_name = $slug . '.' . $file->getClientOriginalExtension();

        DB::table('entreprises')->insert([
            'user_id' => Auth::id(),
            'email' => $email,
            'file_name' => $file_name,
            'description' => $description,
            'community' => $community,
            'slug' => $slug,
            'name' => $name,
            'facebook' => $facebook,
            'twitter' => $twitter,
            'linkedin_id' => $id,
        ]);

        $content = file_get_contents($request->file('picture')->getRealPath());
        Storage::makeDirectory('public/entreprise/');
        Storage::put('public/entreprise/' . $file_name, $content);

        $entreprise_id = intval(DB::getPdo()->lastInsertId());


        $tags_insert = [];
        $explode = array_filter(array_map('intval', explode('-', $tags)), 'is_numeric');

        $i = 0;
        $max = count($explode);

        while ($i < $max) {
            $tags_insert[] = [
                'id_entreprise' => $entreprise_id,
                'id_tag' => $explode[$i],
            ];
            $i++;
        }

        DB::table('tags_link')->insert($tags_insert);

        return redirect()->route('entreprise.profil');
    }

    public function editStore($slug, Request $request)
    {
        $entreprise = DB::table('entreprises')->where('slug', $slug)->where('user_id', Auth::id())->first();

        if (!$entreprise) {
            return Redirect()->back();
        }

        $id = $entreprise->id;

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'name' => 'required|min:10|max:60',
            'email' => 'email|required',
            'tags' => 'nullable',
            'community' => 'integer',
            'twitter_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return Redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $description = $request->get('description');
        $name = $request->get('name');
        $email = $request->get('email');
        $tags = $request->get('tags');
        $community = $request->get('community');
        $twitter = $request->input('twitter_url');
        $facebook = $request->input('facebook_url');

        $slugify = new Slugify();
        $newSlug = $slugify->slugify($name, '-');

        $linkedin = $this->getLinkedIn();

        $myEntreprises = $linkedin->get('v1/companies?format=json&is-company-admin=true');

        $allow = false;

        $i = 0;
        $max = $myEntreprises['_total'];
        while ($i < $max) {

            if ($myEntreprises['values'][$i]['id'] == $entreprise->linkedin_id) {

                $allow = true;
                break;
            }

            $i++;
        }

        if ($allow === false) {
            return Redirect()->route('entreprise.profil');
        }

        $file = $request->file('picture');
        if ($file) {
            $file_name = $newSlug . '.' . $file->getClientOriginalExtension();
        } else {
            $pos = (strrpos($entreprise->file_name, '.') - strlen($entreprise->file_name));

            $file_name = $newSlug . substr($entreprise->file_name, $pos);
        }

        DB::table('entreprises')->where('slug', $slug)->where('user_id', Auth::id())->update([
            'email' => $email,
            'description' => $description,
            'community' => $community,
            'slug' => $newSlug,
            'name' => $name,
            'file_name' => $file_name,
            'facebook' => $facebook,
            'twitter' => $twitter,
        ]);


        $tags_insert = [];
        $explode = array_filter(array_map('intval', explode('-', $tags)), 'is_numeric');

        $i = 0;
        $max = count($explode);

        while ($i < $max) {
            $explode[$i] = intval($explode[$i]);
            if ($explode[$i] > 0) {
                $tags_insert[] = [
                    'id_entreprise' => $id,
                    'id_tag' => $explode[$i],
                ];
            }

            $i++;
        }

        DB::table('tags_link')->where('id_entreprise', $id)->delete();
        DB::table('tags_link')->insert($tags_insert);

        if ($file) {
            $file_name = $newSlug . '.' . $file->getClientOriginalExtension();

            $content = file_get_contents($request->file('picture')->getRealPath());
            Storage::makeDirectory('public/entreprise/');


            Storage::delete('public/entreprise/' . $entreprise->file_name);

            Storage::put('public/entreprise/' . $file_name, $content);
        } elseif ($entreprise->file_name != $file_name) {
            Storage::move('public/entreprise/' . $entreprise->file_name, 'public/entreprise/' . $file_name);
        }

        return redirect()->route('entreprise.profil');
    }
}
