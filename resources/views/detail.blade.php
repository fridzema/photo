@extends('layouts.layout')

@section('content')
	<section id="photo-detail">
		<img src="{{$photo->getMedia('images')->first()->getUrl('large')}}"  width="1140" height="759" />
	</section>

	{{dump($photo->exif)}}
	{{dump($photo->iptc)}}
@endsection