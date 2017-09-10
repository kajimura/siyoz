@extends('layouts.app')
@section('content')
<div class="container">
	<h1>情報編集</h1>
{{--
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/prof" class="btn btn-default" style="margin:20px;">一覧に戻る</a>
		</div>
	</div>
--}}
@if (count($errors) > 0)
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
	<form method="post" action="{{$apl_code_uri}}/prof/{{$fuser->id}}" class="form-horizontal">
		{!! method_field('put') !!}
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
			<label class="col-sm-4 col-xs-12 control-label">一言(プロフィール)</label>
			<div class="col-sm-8 col-xs-12">
			<input type="text" name="text" value="{{ old('text', $fuser->text) }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4 control-label">場所</label>
			<div class="col-xs-8">
			<input type="text" name="location" value="{{ old('location', $fuser->location) }}" class="form-control">
			</div>
		</div>
{{--
		<div class="form-group">
			<label>自分のページ</label>
			https://poke.ther.site/prof/
			<input type="text" name="code" value="{{ old('code', $fuser->code) }}" class="form-control">
		</div>
--}}
		<div class="form-group">
{{--
			<label class="col-xs-12">Facebook</label>
--}}
			<label class="col-xs-4 control-label">https://facebook.com/</label>
			<div class="col-xs-8">
				<input type="text" name="facebook_code" value="{{ old('facebook_code', $fuser->facebook_code) }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
{{--
			<label class="col-xs-12">Twitter</label>
--}}
			<label class="col-xs-4 control-label">https://twitter.com/</label>
			<div class="col-xs-8">
			<input type="text" name="twitter_code" value="{{ old('twitter_code', $fuser->twitter_code) }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 col-xs-12 control-label">ブログURL</label>
			<div class="col-sm-8 col-xs-12">
			<input type="text" name="blog_url" value="{{ old('blog_url', $fuser->blog_url) }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 col-xs-12 control-label">タグ(スペース区切り)</label>
			<div class="col-sm-8 col-xs-12">
			<input type="text" name="tag" value="{{ old('tag', $fuser->tag) }}" class="form-control">
			</div>
		</div>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="更新" class="btn btn-primary btn-block">
	</form>
</div>
@endsection
