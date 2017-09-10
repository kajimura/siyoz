@extends('layouts.app')
@section('content')
<div class="container">
	<h1>申請詳細</h1>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/match/{{$appointment->match_id}}" class="btn btn-default" style="margin:20px;">イベント詳細確認</a>
		</div>
	</div>

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

	@if ($appointment->status_id == \App\Appointment::STATUS_ID_CANCEL)
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
					{{$appointment->cancel_text}}<br />
					<span class="talk-date">{{$appointment->updated_at}}</span>
				</span>
			</p>
		</div>
	@endif
<hr />
	{{$fuser->name}}さんの返信
	@if ($appointment->status_id == \App\Appointment::STATUS_ID_REQUEST
			|| $appointment->status_id == \App\Appointment::STATUS_ID_CANCEL)
		<div class="alert alert-info" role="alert">
		未返信
		</div>
	@else
		<div id="chat-frame">
			@if ($appointment->status_id == \App\Appointment::STATUS_ID_SUCCESS)
				<span class="chat-talk talk-system" align="center">
					承認しました
				</span>
			@elseif ($appointment->status_id == \App\Appointment::STATUS_ID_NG)
				<span class="chat-talk talk-system" align="center">
					否認しました
				</span>
			@endif
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
