@extends('layouts.app')
@section('content')
<div class="container">
	<h1>情報編集</h1>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/fuser" class="btn btn-primary" style="margin:20px;">一覧に戻る</a>
		</div>
	</div>
	<form method="post" action="{{$apl_code_uri}}/fuser/{{$fuser->id}}">
		{!! method_field('put') !!}
		<div class="form-group">
			<label>名前</label>
			<input type="text" name="name" value="{{$fuser->name}}" class="form-control">
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="text" name="email" value="{{$fuser->email}}" class="form-control">
		</div>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="更新" class="btn btn-primary">
	</form>
</div>
@endsection

