<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @yield('stylesheets')
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
	  <a class="item icon" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
	    <i class="sign out icon"></i>
	  </a>
			@yield('content')

		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			{{ csrf_field() }}
		</form>
    <script src="{{asset('js/admin.js')}}"></script>
    <script type="text/javascript">Dropzone.autoDiscover = false;</script>
    @yield('footer-inline-script')
</body>
</html>
