<!DOCTYPE html>
<html>
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>{{ config('app.name', 'Robert Fridzema - Rotterdam') }}</title>
      <meta name="description" content="Robert Fridzema, Photography Rotterdam">
      <meta name="keywords" content="robert, fridzema, rotterdam, photo, photgraph, camera">
      <style>{!!file_get_contents('css/app.css')!!}</style>
    </head>
    <body>
      <article>
      	<h1>Robert Fridzema</h1>
        @yield('content')
      </article>
      <footer>
        <a href="mailto:fridzema@gmail.com" rel="author">Robert Fridzema</a>
      </footer>
    </body>
</html>