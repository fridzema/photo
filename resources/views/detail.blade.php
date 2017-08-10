@extends('layouts.layout')

@section('content')
<img src="https://static.fridzema.com{{$photo->getMedia('images')->first()->getUrl('large')}}" alt="{{ str_random(3) }}" width="1800"  />
@endsection