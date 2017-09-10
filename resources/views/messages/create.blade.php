@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-6">
		<h1>
			<img src="{{$to_fuser->avatar}}" width="30px" />
			{{$to_fuser->name}}さんへ
		</h1>
		</div>
		<div class="col-sm-6" align="right">
			<a href="{{$apl_code_uri}}/match/{{$match->id}}" class="btn btn-default" style="margin:20px;">マッチ画面に戻る</a>
		</div>
	</div>
@if (count($errors) > 0)
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

	<form method="post" action="{{$apl_code_uri}}/message">
		<div class="form-group">
			<label for="text">
				<img src="{{$self_fuser->avatar}}" width="20px" />
				{{$self_fuser->name}}
				一言メッセージ
			</label>
			<textarea id="text" name="text" class="form-control" rows="3">{{ old('text') }}</textarea>
		</div>
		<input type="hidden" name="match_id" value="{{$match->id}}" >
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="返信" class="btn btn-primary btn-block">
	</form>
<br />
<link rel="stylesheet" href="{{$apl_code_uri}}/assets/css/chat-talk.css" />
<div id="chat-frame">
	@foreach ($messages as $key => $message)
		@if ($message->fuser)
			@if ($message->text)
				@if ($self_fuser_id != $message->fuser->id)
					<p class="chat-talk">
						<span class="talk-icon">
							<a href="{{$apl_code_uri}}/prof/{{$message->fuser->id}}">
								<img src="
										{{$message->fuser->avatar}}
								" alt="tartgeticon" width="50px" height="50px" alt="{{$message->fuser->name}}" />
							</a>
<br />
<span class="talk-name">
{{$message->fuser->name}}
</span>
						</span>
						<span class="talk-content">
							{{$message->text}}<br />
							<span class="talk-date">{{$message->created_at}}</span>
						</span>
					</p>
				@else
					<p class="chat-talk mytalk">
						<span class="talk-icon">
							<a href="{{$apl_code_uri}}/prof/{{$message->fuser->id}}">
								<img src="
										{{$message->fuser->avatar}}
								" alt="tartgeticon" width="50px" height="50px" alt="{{$message->fuser->name}}" />
							</a>
<br />
<span class="talk-name">
{{$message->fuser->name}}
</span>
						</span>
						<span class="talk-content">
							{{$message->text}}<br />
							<span class="talk-date">{{$message->created_at}}</span>
						</span>
					</p>
				@endif
			@endif
			@if ($message->status_msg)
				<span class="chat-talk talk-system" align="center">{{$message->status_msg}}</span>
			@endif
		@endif
	@endforeach
	</div>
</div>
@endsection
