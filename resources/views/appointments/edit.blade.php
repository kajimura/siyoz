@extends('layouts.app')
@section('content')
<div class="container">
	<h1>申請結果返答</h1>
{{--
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/appointment" class="btn btn-default" style="margin:20px;">申請受付一覧</a>
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

	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-xs-12" style="font-size:50px">
					{{$meet->day}}
				</div>
				<div class="col-xs-12" style="font-size:40px">
					@if ($match)
					{{ substr($match->start_time, 0, 5) }}〜
					{{ substr($match->end_time, 0, 5) }}
					@else
						イベントが削除されてます
					@endif
				</div>
				<div class="col-sm-12">
					{{$meet->location_name}}
				</div>
				<div class="col-sm-12">
					{{$meet->location_address}}
				</div>
				<div class="col-sm-12">
					<img src="{{$fuser->avatar}}" width="20px" height="20px" />
					{{$meet->text}}
				</div>
			</div>
		</div>
	</div>
	<hr />

	{{$guest_fuser->name}}さんから申請がありました。
	<link rel="stylesheet" href="/assets/css/chat-talk.css" />
		<div id="chat-frame">
					<p class="chat-talk">
						<span class="talk-icon">
							<a href="{{$apl_code_uri}}/prof/{{$guest_fuser->id}}">
								<img src="
										{{$guest_fuser->avatar}}
								" alt="tartgeticon" width="50px" height="50px" alt="{{$guest_fuser->name}}" />
							</a>
							<br />
							<span class="talk-name">
							{{$guest_fuser->name}}
							</span>
						</span>
						<span class="talk-content">
							{{$appointment->guest_text}}<br />
							<span class="talk-date">{{$appointment->created_at}}</span>
						</span>
					</p>
		</div>
<hr />
	{{$fuser->name}}の返信
	@if ($appointment->status_id == \App\Appointment::STATUS_ID_REQUEST)
		<form method="post" action="{{$apl_code_uri}}/appointment/{{$appointment->id}}">
			{!! method_field('put') !!}
			<div class="form-group">
	
				<label>結果 [承認/否認]</label>
					<select class="form-control" name="status_id">
					<option value="">選択してください</option>
					<option @if ( old('status_id') == \App\Appointment::STATUS_ID_SUCCESS) selected @endif  value="{{ \App\Appointment::STATUS_ID_SUCCESS }}">承認</option>
					<option @if ( old('status_id') == \App\Appointment::STATUS_ID_NG) selected @endif value="{{ \App\Appointment::STATUS_ID_NG }}">否認</option>
					</select>
				<label>一言</label>
				<input type="text" name="text" value="{{ old('text') }}" class="form-control">
			</div>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="submit" value="返答" class="btn btn-primary">
		</form>
	@else
		<div id="chat-frame">
			<span class="chat-talk talk-system" align="center">
				@if ($appointment->status_id == \App\Appointment::STATUS_ID_SUCCESS)
					承認しました
				@elseif ($appointment->status_id == \App\Appointment::STATUS_ID_NG)
					否認しました
				@endif
			</span>
					<p class="chat-talk mytalk">
						<span class="talk-icon">
							<a href="{{$apl_code_uri}}/prof/{{$fuser->id}}">
								<img src="
										{{$fuser->avatar}}
								" alt="tartgeticon" width="50px" height="50px" alt="{{$fuser->name}}" />
							</a>
							<br />
							<span class="talk-name">
							{{$fuser->name}}
							</span>
						</span>
						<span class="talk-content">
							{{$appointment->text}}<br />
							<span class="talk-date">{{$appointment->updated_at}}</span>
						</span>
					</p>
		</div>
	@endif



</div>
@endsection

