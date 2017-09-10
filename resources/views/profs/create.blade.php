@extends('layouts.app')
@section('content')
<div class="container">
	<h1>情報編集</h1>
@if (count($errors) > 0)
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
	<form method="post" action="{{$apl_code_uri}}/prof" class="form-horizontal">
		<div class="form-group">
			<label class="col-xs-4 control-label">名前
			<font color="#ff6666">＊</font>
			</label>
			<div class="col-xs-8">
			<input type="text" name="name" value="{{ old('name', $fuser->name) }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4 control-label">Email (公開されません)
			<font color="#ff6666">＊</font>
			</label>
			<div class="col-xs-8">
			<input type="text" name="email" value="{{ old('email', $fuser->email) }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4 control-label">https://facebook.com/</label>
			<div class="col-xs-8">
				<input type="text" name="facebook_code" value="{{ old('facebook_code', $facebook_code) }}" class="form-control">
			</div>
		</div>

		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="登録" class="btn btn-primary btn-block">
	</form>
</div>


@endsection
