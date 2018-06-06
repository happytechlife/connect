<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Search extends Controller
{

    public static function communities(Request $request){
        $search = $request->input('q');

        $data = [];


        if ($search){
            $builder = [];
            $explode = explode(' ',$search);

            $i = 0;
            $max = count($explode);
            while($i < $max){

                $length = strlen($explode[$i]) / 3;
                $explode[$i] = mb_strtolower($explode[$i],'UTF-8');

                $builder[] = '(
                LENGTH(`name`)
                    - LENGTH( REPLACE ( LOWER(`name`),"'.$explode[$i].'", "") )
                ) / '.$length.'
                +
                (
                    LENGTH(`description`)
                    - LENGTH( REPLACE ( LOWER(`description`),"'.$explode[$i].'", "") )
                ) / '.$length;

                $i++;
            }


            $bddData = DB::select('
                select 
                    `name`,
                    `id`,
                    CEIL ('.join('+',$builder).') AS `count`
                from `community`
                 where ('.join('+',$builder).')>0
                order by `count` desc
                limit 9
            ');

            $i = 0;
            $max = count($bddData);
            while($i < $max){

                $data[] = [
                    'name' => $bddData[$i]->name,
                    'id' => $bddData[$i]->id
                ];

                $i++;
            }
        }

        return response()->json($data);
    }

    public static function tags(Request $request){
        $search = $request->input('q');

        $data = [];


        if ($search){
            $builder = [];
            $explode = explode(' ',$search);

            $i = 0;
            $max = count($explode);
            while($i < $max){

                $length = strlen($explode[$i]) / 3;
                $explode[$i] = mb_strtolower($explode[$i],'UTF-8');

                $builder[] = '(
                LENGTH(`tag`)
                    - LENGTH( REPLACE ( LOWER(`tag`),"'.$explode[$i].'", "") )
                ) / '.$length.'
                +
                (
                    LENGTH(`description`)
                    - LENGTH( REPLACE ( LOWER(`description`),"'.$explode[$i].'", "") )
                ) / '.$length;

                $i++;
            }


            $bddData = DB::select('
                select 
                    `tag`,
                    `id`,
                    CEIL ('.join('+',$builder).') AS `count`
                from `tags`
                 where ('.join('+',$builder).')>0
                order by `count` desc
                limit 9
            ');

            $i = 0;
            $max = count($bddData);
            while($i < $max){

                $data[] = [
                    'tag' => $bddData[$i]->tag,
                    'id' => $bddData[$i]->id
                ];

                $i++;
            }
        }

        return response()->json($data);
    }

    public static function json(Request $request){
        $search = $request->input('q');

        $data = [
            'tags' => [],
            'entreprises' => [],
            'community' => [],
        ];


        if ($search){
            $searchCommunityBuilder = [];
            $searchTagBuilder = [];
            $explode = explode(' ',$search);

            $i = 0;
            $max = count($explode);
            while($i < $max){

                $length = strlen($explode[$i]) / 3;
                $explode[$i] = mb_strtolower($explode[$i],'UTF-8');

                $searchCommunityBuilder[] = '(
                LENGTH(`name`)
                    - LENGTH( REPLACE ( LOWER(`name`),"'.$explode[$i].'", "") )
                ) / '.$length.'
                +
                (
                    LENGTH(`description`)
                    - LENGTH( REPLACE ( LOWER(`description`),"'.$explode[$i].'", "") )
                ) / '.$length;

                $searchTagBuilder[] = '(
                LENGTH(`tag`)
                    - LENGTH( REPLACE ( LOWER(`tag`),"'.$explode[$i].'", "") )
                ) / '.$length.' * 3
                +
                (
                    LENGTH(`description`)
                    - LENGTH( REPLACE ( LOWER(`description`),"'.$explode[$i].'", "") )
                ) / '.$length;

                $i++;
            }


            $bddData = DB::select('
                select 
                    `name`,
                    `slug`,
                    CEIL ('.join('+',$searchCommunityBuilder).') AS `count`
                from `community`
                 where ('.join('+',$searchCommunityBuilder).')>0
                order by `count` desc
                limit 9
            ');

            $i = 0;
            $max = count($bddData);
            while($i < $max){

                $data['community'][] = [
                    'name' => $bddData[$i]->name,
                    'link' => route('community.view',['slug' => $bddData[$i]->slug])
                ];

                $i++;
            }

            $bddData = DB::select('
                select 
                    `tag`,
                    `slug`,
                    CEIL ('.join('+',$searchTagBuilder).') AS `count`
                from `tags`
                where CEIL ('.join('+',$searchTagBuilder).')>0
                order by `count` desc
                limit 9
            ');

            $i = 0;
            $max = count($bddData);
            while($i < $max){

                $data['tags'][] = [
                    'name' => $bddData[$i]->tag,
                    'link' => route('tag.view',['slug' => $bddData[$i]->slug])
                ];

                $i++;
            }
        }else{
            $bddData = DB::table('community')->limit(9)->get();

            $i = 0;
            $max = count($bddData);
            while($i < $max){

                $data['community'][] = [
                    'name' => $bddData[$i]->name,
                    'link' => route('community.view',['slug' => $bddData[$i]->slug])
                ];

                $i++;
            }

            $bddData = DB::table('tags')->limit(9)->get();

            $i = 0;
            $max = count($bddData);
            while($i < $max){

                $data['tags'][] = [
                    'name' => $bddData[$i]->tag,
                    'link' => route('tag.view',['slug' => $bddData[$i]->slug])
                ];

                $i++;
            }
        }

        return response()->json($data);
    }
}
