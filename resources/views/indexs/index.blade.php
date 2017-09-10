@extends('layouts.app')

@section('content')

<link href="/assets/css/login2.css" type="text/css" rel="stylesheet"/>

<div class="container">
	<div class="page-lock">
		<div class="page-logo">
		</div>
		<div class="page-body">
			<div class="lock-head">
				{{$apl_name}}<br />
			</div>
			<div class="lock-body">
				<form class="lock-form pull-left" action="index.html" method="post">
					<h4>
					</h4>
					<div class="form-actions" align="center">
<center>
		<a href="{{$apl_code_uri}}/facebook" class="btn btn-block btn-lg" style="background-color:#3c5d96;color:#fff;">
	facebookで登録 (21歳以上)</a>
</center>
					</div>
				</form>
			</div>
			<div class="lock-bottom">
{{--
				<a href="">Not Amanda Smith?</a>
--}}
			</div>
		</div>
	</div>

</div>


<style type="text/css">
body {
background-image: url("/assets/img/top/PEZ86_kamigakourintenshinohashigo_TP_V.jpg");
}
</style>

@endsection
