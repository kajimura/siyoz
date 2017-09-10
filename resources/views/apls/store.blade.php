@extends('layouts.app')
@section('content')
<div class="container">
	<h1>登録ありがとうございます。</h1>
	<div class="row">
		<div class="col-sm-12">
{{--
			よければ当サイトのfacebookも登録ください。
			@include('_parts/facebook_likebox')
--}}
		</div>
		<div class="col-sm-12">
{{--
			<a href="{{$apl_code_uri}}/prof/{{$user->id}}" class="btn btn-default">自分のプロフを見る</a>
--}}
		</div>
	</div>
</div>
@endsection
