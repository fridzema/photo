@extends('layouts.layout')

@section('content')
@foreach($photos as $photo)
	<a href="{{route('photo', $photo->id)}}"><img src="https://static.fridzema.com{{ $photo->getMedia('images')->first()->getUrl('medium') }}" alt="{{ str_random(3) }}" width="600" /></a>
@endforeach
@endsection