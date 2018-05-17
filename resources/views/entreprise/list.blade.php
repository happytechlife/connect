
@php($htmlTags = '')
@php($tagsList = [])
@foreach($tags as $tag)
    @php($tagsList[] = $tag->id)
@endforeach



@foreach($entreprises as $entreprise)
    <form method="POST" action="{{route('entreprise.update')}}">
        {{ method_field('PUT') }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$entreprise->id}}">
        <input type="hidden" name="tagList" value="{{ join(',',$tagsList) }}">
        <input type="text" name="name" value="{{$entreprise->name}}" placeholder="The name...">
        <br><select name="community">
            @php($name = '')
            @php($options = '')
            @foreach($communautes as $communaute)

                @if ($communaute->id != $entreprise->community)
                    @php($options .= '<option value="'.$communaute->id.'">'.$communaute->name.'</option>')
                @else
                    @php($name = $communaute->name)
                @endif
            @endforeach
            <option value="{{$entreprise->community}}">{{$name}}</option>{!! $options !!}
        </select>




        <br><input type="text" name="description" value="{{$entreprise->description}}" placeholder="Description ...">
        @foreach($tags as $tag)

            @php($checked = '')

            @foreach($tags_entreprises as $tags_entreprise)

                @if($tags_entreprise->id_entreprise == $entreprise->id and $tags_entreprise->id_tag == $tag->id)
                    @php($checked = 'checked="true"')
                @endif
            @endforeach

            <br><input {{$checked}} id="form-{{$entreprise->id}}-label-{{$tag->id}}" type="checkbox" name="tag_{{$tag->id}}"><label for="form-new-label-'.$tag->id.'">{{$tag->tag}}</label>
        @endforeach
        <br><input type="submit" value="Modifier l'entreprise">
    </form>
    <br><br>
    <form method="POST" action="{{route('entreprise.delete')}}">
        {{ method_field('DELETE') }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$entreprise->id}}">
        <input type="submit" value="Supprimer l'entreprise">
    </form>
    <br><br>
    <a href="{{route('entreprise.view',['slug' => $entreprise->slug])}}">Voir la page</a>
    <br><br><br>
    <hr>
    <br><br><br>
@endforeach
<form method="POST" action="{{route('entreprise.new')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="tagList" value="{{ join(',',$tagsList) }}">
    <input type="text" name="name" placeholder="The name...">
    <br><select name="community">
        @foreach($communautes as $communaute)
            <option value="{{$communaute->id}}">{{$communaute->name}}</option>
        @endforeach
    </select>
    @foreach($tags as $tag)
        <input id="form-new-label-{{$tag->id}}" type="checkbox" name="tag_{{$tag->id}}"><label for="form-new-label-'.$tag->id.'">{{$tag->tag}}</label>
    @endforeach
    <br><input type="text" name="description" placeholder="Description ...">
    <br><input type="submit" value="Ajouter une communauté">
</form>