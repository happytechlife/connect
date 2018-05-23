@extends('templates.admin')

@section('page_class','community_list')

@section('content')
    <section class="list">
        <div class="width-1200">

            <h1>Tags</h1>

            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Tag</td>
                        <td class="left">Description</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>#{{$tag->id}}</td>
                            <td>{{$tag->tag}}</td>
                            <td class="left">{{$tag->description}}</td>
                            <td><a href="{{route('admin.tag.edit',['slug' => $tag->slug])}}">Modifier</a><a href="{{route('admin.tag.delete',['id' => $tag->id])}}">Supprimer</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{$tags->links()}}
        </div>
    </section>
@endsection
