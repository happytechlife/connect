@foreach($entreprises as $entreprise)
    <form method="POST" action="{{route('entreprise.update')}}">
        {{ method_field('PUT') }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$entreprise->id}}">
        <input type="text" name="name" value="{{$entreprise->name}}" placeholder="The name...">
        <select name="community">
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
        <input type="text" name="description" value="{{$entreprise->description}}" placeholder="Description ...">
        <input type="submit" value="Modifier l'entreprise">
    </form>

    <form method="POST" action="{{route('entreprise.delete')}}">
        {{ method_field('DELETE') }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$entreprise->id}}">
        <input type="submit" value="Supprimer l'entreprise">
    </form>

    <a href="{{route('entreprise.view',['slug' => $entreprise->slug])}}">Voir la page</a>

    <hr>
@endforeach
<form method="POST" action="{{route('entreprise.new')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" name="name" placeholder="The name...">
    <select name="community">
        @foreach($communautes as $communaute)
            <option value="{{$communaute->id}}">{{$communaute->name}}</option>
        @endforeach
    </select>
    <input type="text" name="description" placeholder="Description ...">
    <input type="submit" value="Ajouter une communauté">
</form>