@extends('layouts.layout')

@section('content')
	<section id="photo-detail">
		<img src="//static.fridzema.com/{{$photo->getMedia('images')->first()->getUrl('large')}}"  width="1140" height="759" />
	</section>
@endsection