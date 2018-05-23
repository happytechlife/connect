@extends('templates.admin')

@section('page_class','community_list')

@section('content')
    <section class="list">
        <div class="width-1200">

            <h1>Communautées</h1>

            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Lieu</td>
                        <td class="left">Description</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($communities as $community)
                        <tr>
                            <td>#{{$community->id}}</td>
                            <td>{{$community->name}}</td>
                            <td class="left">{{$community->description}}</td>
                            <td><a href="{{route('admin.community.edit',['slug' => $community->slug])}}">Modifier</a><a href="{{route('admin.community.delete',['slug' => $community->slug])}}">Supprimer</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{$communities->links()}}
        </div>
    </section>
@endsection
