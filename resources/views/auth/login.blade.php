@extends('admin.layouts.layout')

@section('content')
<section id="login">
	<form action="{{ route('login') }}" method="POST" role="form">
	    {{ csrf_field() }}

	    <input autofocus="" class="form-control" id="email" name="email" required="" type="email"  placeholder="Email" value="{{ old('email') }}" />

	    @if ($errors->has('email'))
	    	<div class="error email"><strong>{{ $errors->first('email') }}</strong></div>
	    @endif

	    <input id="password" name="password" required="" type="password" placeholder="Password" />

	    @if ($errors->has('password'))
	      <div class="error password">
	          <strong>{{ $errors->first('password') }}</strong>
	      </div>
	    @endif
{{--
			<label for="remember">Remember me</label>
	    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} /> --}}

	    <button type="submit">Login</button>

	    @if ($errors->has('email') || $errors->has('password'))
	    	<a href="{{ route('password.request') }}">Forgot Your Password?</a>
	    @endif
	</form>
</section>
@endsection
