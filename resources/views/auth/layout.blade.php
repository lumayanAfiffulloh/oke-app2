<head>
	<link rel="icon" href="{{ asset('img/undip.png') }}">
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name', 'Laravel'))</title>
  <link rel="shortcut icon" type="image/png" href={{ asset("modern/src/assets/images/logos/favicon.png") }}/>
  <link rel="stylesheet" href= {{ asset("modern/src/assets/css/styles.min.css") }} />
  <link rel="icon" href="{{ asset('img/undip.png') }}">
</head>
<body>
  @yield('content')
</body>

</html>