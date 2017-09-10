@extends('layouts.app')
@section('content')
<div class="container">
	<h1>新規作成</h1>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/fusers" class="btn btn-primary" style="margin:20px;">一覧に戻る</a>
		</div>
	</div>
	<form method="post" action="{{$apl_code_uri}}/fusers">
		<div class="form-group">
			<label>名前</label>
			<input type="text" name="name" value="" class="form-control">
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="text" name="email" value="" class="form-control">
		</div>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="登録" class="btn btn-primary">
	</form>
</div>
@endsection
