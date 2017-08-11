@extends('admin.layouts.layout')

@section('stylesheets')
	<link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
@endsection

@section('content')
<form id="dropzone" class="dropzone">
  <div class="dz-message" data-dz-message><span>Upload</span></div>
</form>

<div id="photos">
	@foreach($photos as $photo)
		<a>
			<img src="{{ cdn($photo->getMedia('images')->first()->getUrl('small')) }}" alt="Photo-{{ $photo->id }}" />
		</a>
	@endforeach
</div>
@endsection