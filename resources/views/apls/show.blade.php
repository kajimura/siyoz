@extends('layouts.app')
@section('content')
<div class="container">
	<h1>{{$fuser->name}}さんのページ</h1>
	<div class="row">
		<div class="col-sm-4">
			<img src="{{$fuser->avatar_original}}" width="300px" /><br />
				<div class="row">
					<div class="col-sm-12">
<link rel="stylesheet" href="/assets/css/sharebutton.css" />
					@if ($fuser->facebook_code)
						<a href="https://facebook.com/{{$fuser->facebook_code}}">
							<img alt="facebook" src="/assets/img/share/d.png" class="spriteImg sprite_icon_facebook_36x36_png img-thumbnail" width="36px" height="36px" />
						</a>
					@endif
					@if ($fuser->twitter_code)
						<a href="https://twitter.com/{{$fuser->twitter_code}}">
							<img alt="twitter" src="/assets/img/share/d.png" class="spriteImg sprite_icon_twitter_36x36_png img-thumbnail" width="36px" height="36px" />
						</a>
					@endif
					@if ($fuser->blog_url)
						<a href="{{$fuser->blog_url}}">
							<img src="/assets/img/share/icon_blog_36x36.png" class="img-thumbnail" />
						</a>
					@endif
					</div>
			</div>
			@if (isset($self_fuser))
				@if ($self_fuser->id == $fuser->id)
				<div class="row">
					<div class="col-xs-6">
						<a href="{{$apl_code_uri}}/prof/{{$fuser->id}}/edit" class="btn btn-primary">編集</a>
					</div>
					<div class="col-xs-6">
						<form method="post" action="{{$apl_code_uri}}/prof/{{$fuser->id}}" onclick="return window.confirm('本当に退会してよろしいですか？')">
							 {!! method_field('delete') !!}
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="submit" value="退会" class="btn btn-danger btn-destroy">
						</form>
					</div>
				</div>
				@endif
			@endif
		</div>
		<div class="col-sm-8 lead">
			{{$fuser->text}}<br />
			<br />
			<div class="row">
				<div class="col-sm-4">
					場所
				</div>
				<div class="col-sm-8">
					{{$fuser->location}}
				</div>
				<div class="col-sm-12">
				</div>
				<div class="col-sm-4">
					タグ
				</div>
				<div class="col-sm-8">
					{{$fuser->tag}}
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			{{$fuser->name}}さんの評価はまだありません
		</div>
	</div>
</div>
@endsection
