<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@if (isset($title)){{$title}} @else {{$apl_name}}@endif</title>
@if (isset($keywords))
<meta name="keywords" content="{{$keywords}}" />
@endif
@if (isset($description))
<meta name="description" content="{{$description}}" />
@endif

	<!-- Fonts -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

	<!-- Styles -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="/assets/css/app.css" />
	{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

	<style>
		body {
			font-family: 'Lato';
		}

		.fa-btn {
			margin-right: 6px;
		}
	</style>
</head>
<body id="app-layout">

@if (Route::currentRouteAction() != "App\Http\Controllers\IndexController@index")

	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">

				<!-- Collapsed Hamburger -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>


				<!-- Branding Image -->
				<a class="navbar-brand" href="{{$apl_code_uri}}/">
					{{$apl_name}}
				</a>
			</div>

			<div class="collapse navbar-collapse" id="app-navbar-collapse">
				<!-- Left Side Of Navbar -->
				<ul class="nav navbar-nav">
{{--
					<li><a href="{{$apl_code_uri}}/home">Home</a></li>
--}}
				</ul>


@if (!preg_match("!/(help/|apl)!", Request::url()))
				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					@if (!Session::get('fuser_id'))
						<li><a href="{{$apl_code_uri}}/facebook">Facebook Login</a></li>
					@else
						<li><a href="{{$apl_code_uri}}/meet">イベント</a></li>
						<li><a href="{{$apl_code_uri}}/appointment">申請受信</a></li>
						<li><a href="{{$apl_code_uri}}/appointment/indexrequest">申請送信
{{--
								<span class="badge">{{$fuser}}</span>
--}}
							</a></li>
						<li><a href="{{$apl_code_uri}}/message">メッセージ</a></li>
						<li><a href="{{$apl_code_uri}}/meet/create">登録</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								{{ Session::get('name') }}<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{$apl_code_uri}}/prof/home"><i class="fa fa-btn"></i>Myページ</a></li>
								<li><a href="{{$apl_code_uri}}/flogout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
							</ul>
						</li>
					@endif
{{--
					<!-- Authentication Links -->
					@if (Auth::guest())
						<li><a href="{{$apl_code_uri}}/login">Login</a></li>
						<li><a href="{{$apl_code_uri}}/register">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								{{ Auth::user()->name }} <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{$apl_code_uri}}/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
							</ul>
						</li>
					@endif
--}}
				</ul>
@endif
			</div>
		</div>
	</nav>
@endif
	@yield('content')

<hr />
<div align="center" class="foot">
@if (!preg_match("!/(apl)!", Request::url()))
[PR] <a href="https://siyoz.net/apl">待ち合わせサイトを作る</a><br />
@endif
<a href="{{$apl_code_uri}}/help/privacy">プライバシーポリシー</a> |
<a href="{{$apl_code_uri}}/help/condition">利用規約</a> |
<a href="{{$apl_code_uri}}/help/company">運営会社</a> |
<a href="https://docs.google.com/forms/d/e/1FAIpQLScXs72XVCY7aQYGAW_WShACX8Py04xY8LCzN0gKEBdE_WIjtQ/viewform?formkey=dGQ1VjRuR010MEd3YV84eW1WOUtMdEE6MQ">問い合わせ</a>
</div>
<br />
<div align="center">
(c) {{$apl_name}}
</div>

	<!-- JavaScripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

@if (!preg_match("/-test/", Request::url()))
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-82434577-1', 'auto');
  ga('send', 'pageview');
</script>
@endif

</body>
</html>
