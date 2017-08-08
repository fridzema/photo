@extends('layouts.layout')

@section('content')
@foreach($photos as $photo)
	<a href="{{route('photo', $photo->id)}}"><figure><img src="https://static.fridzema.com{{ $photo->getMedia('images')->first()->getUrl('medium') }}" /></figure></a>
@endforeach
@endsection