<form method="POST" action="{{route('tagCreate')}}" style="margin-bottom:100px;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" name="tag" placeholder="add a tag...">
    <input type="submit" value="add">
</form>
@foreach($tags as $tag)
    <div>
        <form method="POST" action="{{route('tagUpdate')}}">
            {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{$tag->id}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="tag" value="{{$tag->tag}}" placeholder="edit a tag...">
            <input type="submit" value="edit">
        </form>
        <form method="POST" action="{{route('tagDelete')}}">
            {{ method_field('DELETE') }}
            <input type="hidden" name="id" value="{{$tag->id}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" value="DELETE">
        </form>
    </div>

@endforeach