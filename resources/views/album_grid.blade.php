@extends('layouts.layout')

@section('content')
@foreach($photos as $photo)
	<a href="{{route('photo', $photo->id)}}"><img src="{{ cdn($photo->getMedia('images')->first()->getUrl('medium')) }}" alt="Photo-{{ $photo->id }}" width="600" /></a>
@endforeach
@endsection