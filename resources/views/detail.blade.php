@extends('layouts.layout')

@section('content')
<img src="https://static.fridzema.com{{$photo->getMedia('images')->first()->getUrl('large')}}"  width="1200" height="800" />
@endsection