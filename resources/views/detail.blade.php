@extends('layouts.layout')

@section('content')
<img src="https://static.fridzema.com{{$photo->getMedia('images')->first()->getUrl('large')}}"  width="1200"  />1
@endsection