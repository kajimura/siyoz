@extends('layouts.app')
@section('content')
<div class="container">
{{--
	<h1>予定詳細</h1>
	<div class="row">
		<div class="col-sm-12">
		</div>
	</div>
--}}
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-6" style="font-size:50px">
					{{$meet->day}}
				</div>
				<div class="col-sm-6" align="right">
					<a href="{{$apl_code_uri}}/meet/{{$meet->id}}" class="btn btn-default" style="margin:20px;">この主催者の同日のイベント</a>
				</div>
				<div class="col-sm-6" style="font-size:40px">
					{{ substr($match->start_time, 0, 5) }}〜
					{{ substr($match->end_time, 0, 5) }}
				</div>
				<div class="col-sm-6" align="right">
					@if ($self_fuser_id == $match->fuser_id)
						<form method="post" action="{{$apl_code_uri}}/match/{{$match->id}}">
							 {!! method_field('delete') !!}
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="submit" value="このイベントを削除" class="btn btn-danger btn-sm btn-destroy" onclick="return window.confirm('本当に削除してよろしいですか？')">
						</form>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					{{$meet->location_name}}
				</div>
				<div class="col-sm-12">
					{{$meet->location_address}}
					(<a href="https://www.google.co.jp/maps/place/{{$meet->lat}},{{$meet->lng}}/@\{{$meet->lat}},{{$meet->lng}},18z?hl=ja" target="_blank">地図</a>)
				</div>
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-sm-12">
			@if (isset($guest_fuser))
				<span class="alert alert-success">成立</span>
			@endif
		</div>
		<div class="col-sm-6">
			<h2>主催者</h2>
			@if ($fuser)
			<h4>{{$fuser->name}}</h4>
			<a href="{{$apl_code_uri}}/prof/{{$fuser->id}}"><img src="{{$fuser->avatar}}" /></a><br />
			{{$fuser->text}}<br />
			@else
				<h4>メンバーが存在しません</h4>
			@endif
			<br />
			一言<br />
			{{$meet->text}}<br />
			{{$meet->tag}}<br />
		</div>
		<div class="col-sm-6">
			<h2>ゲスト</h2>
			@if (isset($guest_fuser))
				<h4>{{$guest_fuser->name}}</h4>
				<a href="{{$apl_code_uri}}/prof/{{$guest_fuser->id}}"><img src="{{$guest_fuser->avatar}}"/></a><br />
				{{$guest_fuser->text}}<br />
				<br />
				@if ($self_fuser_id == $match->fuser_id
						|| $self_fuser_id == $match->guest_fuser_id
						)
					<a href="{{$apl_code_uri}}/message/create/match_id/{{$match->id}}" class="btn btn-primary">メッセージ送信</a><br />
				@endif
			@else
				まだマッチングしていません<br />
			@endif
			<hr />
			@if ($self_fuser_id > 0)
				@if ($self_fuser_id != $match->fuser_id)
					{{-- 他人 --}}
					<div>
					@if ($self_appointment)
						@if ($self_appointment->status_id == \App\Appointment::STATUS_ID_REQUEST)
						<a href="{{$apl_code_uri}}/appointment/{{$self_appointment->id}}" class="btn btn-success">ミーティング申請済</a>
						@endif
					@else
						@if (preg_match("/before/", $day_diff))
							<div class="btn btn-default btn-sm btn-block">既に終了しています</div>
						@else
							<a href="{{$apl_code_uri}}/appointment/create/match_id/{{$match->id}}" class="btn btn-primary">ミーティング申請</a><br />
						@endif
					@endif
					</div>
				@else
					@if (preg_match("/before/", $day_diff))
						<div class="btn btn-default btn-sm btn-block">既に終了しています</div>
					@endif
					{{-- 自分 --}}
					@if (count($appointments))
						<table class="table table-striped">
						@foreach ($appointments as $appointment)
							@if (isset($appointment->guest_fuser))
								<tr>
									<td>{{$appointment->guest_fuser->name}}</td>
									<td><a href="{{$apl_code_uri}}/prof/{{$appointment->guest_fuser->id}}"><img src="{{$appointment->guest_fuser->avatar}}" width="50px" height="50px" /></a></td>
								@if ($appointment->status_id == App\Appointment::STATUS_ID_REQUEST)
								<td class="active">
								<a href="{{$apl_code_uri}}/appointment/{{$appointment->id}}/edit" class="btn btn-primary btn-block">返答</a>
								</td>
								@elseif ($appointment->status_id == App\Appointment::STATUS_ID_SUCCESS)
								<td class="success">
									成立
								</td>
								@elseif ($appointment->status_id == App\Appointment::STATUS_ID_NG)
								<td class="warning">
									否認
								</td>
								@endif
								</tr>
							@endif
						@endforeach
						</table>
					@endif
				@endif
			@endif
			申請者:{{$match->appointment_cnt}}人
		</div>
	</div>
</div>
@endsection
