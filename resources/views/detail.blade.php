@extends('layouts.layout')

@section('content')
<img src="{{ cdn($photo->getMedia('images')->first()->getUrl('large')) }}" alt="Photo-{{ $photo->id }}" width="1800"  />
@endsection