@extends('layouts.app')
@section('content')
<div class="container">
	<h1>待ち合わせシステム作成</h1>
@if (count($errors) > 0)
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
	<form method="post" action="{{$apl_code_uri}}" class="form-horizontal">
		<div class="form-group">
			<label class="col-xs-4 control-label">待ち合わせサイト名
			<font color="#ff6666">＊</font>
			</label>
			<div class="col-xs-8">
			<input type="text" name="name" value="{{ old('name', $apl->name) }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4 control-label">自分のページ<br />http://siyoz.net/[<font color="red">xxxx</font>]<br />英数字4文字以上
			<font color="#ff6666">＊</font>
			</label>
			<div class="col-xs-8">
			<input type="text" name="code" value="{{ old('code', $apl->code) }}" class="form-control">
			</div>
		</div>

		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="登録" class="btn btn-primary btn-block">
	</form>
</div>


@endsection
