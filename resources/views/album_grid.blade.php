@extends('layouts.layout')

@section('content')
@foreach($photos as $photo)
	<a href="{{route('photo', $photo->id)}}"><figure><img src="https://static.fridzema.com{{ $photo->getMedia('images')->first()->getUrl('medium') }}" width="279" height="186" /></figure></a>
@endforeach
@endsection