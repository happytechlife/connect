@foreach($communautes as $communaute)
    <form method="POST" action="{{route('community.update')}}">
        {{ method_field('PUT') }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$communaute->id}}">
        <input type="text" name="name" value="{{$communaute->name}}" placeholder="The name...">
        <input type="text" name="longitude" value="{{$communaute->longitude}}" placeholder="The longitude...">
        <input type="text" name="latitude" value="{{$communaute->latitude}}" placeholder="The latitude...">
        <input type="text" name="description" value="{{$communaute->description}}" placeholder="Description ...">
        <input type="submit" value="Modifier la communauté">
    </form>

    <form method="POST" action="{{route('community.delete')}}">
        {{ method_field('DELETE') }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$communaute->id}}">
        <input type="submit" value="Supprimer la communauté">
    </form>
    <a href="{{route('community.view',['slug' => $communaute->slug])}}">Voir la page</a>
    <hr>
@endforeach
<form method="POST" action="{{route('community.new')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" name="name" placeholder="The name...">
    <input type="text" name="longitude" placeholder="The longitude...">
    <input type="text" name="latitude" placeholder="The latitude...">
    <input type="text" name="description" placeholder="Description ...">
    <input type="submit" value="Ajouter une communauté">
</form>