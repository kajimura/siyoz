@extends('layouts.app')
@section('content')
<div class="container">
<h1>申請受信一覧</h1>
{{--
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="{{$apl_code_uri}}/appointment">申請受信一覧</a></li>
  <li role="presentation"><a href="{{$apl_code_uri}}/appointment/indexrequest">申請送信一覧</a></li>
</ul>
--}}
	<table class="table table-striped">
			<tr>
				<td colspan="2">主催者</td>
				<td>場所</td>
				<td>日付</td>
				<td>開始</td>
				<td>終了</td>
				<td>イベント</td>
				<td>ステータス</td>
			</tr>
	@if (count($appointments))
		@foreach($appointments as $appointment)
			<tr>
				@if ($appointment->guest_fuser)
				<td><a href="{{$apl_code_uri}}/prof/{{$appointment->guest_fuser->id}}"><img src="{{$appointment->guest_fuser->avatar}}" width="50px" height="50px" /></a></td>
				<td>{{$appointment->guest_fuser->name}}</td>
				@else
				<td></td>
				<td>ユーザが退会しました</td>
				@endif
				@if ($appointment->meet)
					<td>{{$appointment->meet->location_name}}</td>
					<td>{{$appointment->meet->day}}</td>
					@if ($appointment->match)
						<td>{{ substr($appointment->match->start_time, 0, 5) }}</td>
						<td>{{ substr($appointment->match->end_time, 0, 5) }}</td>
					@else
						<td>削除</td>
						<td>削除</td>
					@endif
				@endif
				<td><a href="{{$apl_code_uri}}/match/{{$appointment->match_id}}" class="btn btn-default btn-sm">詳細</a></td>
					@if ($appointment->status_id == \App\Appointment::STATUS_ID_REQUEST)
						<td class="warning">申請あり</td>
						<td><a href="{{$apl_code_uri}}/appointment/{{$appointment->id}}/edit" class="btn btn-primary btn-sm">返答</a></td>
					@elseif ($appointment->status_id == \App\Appointment::STATUS_ID_SUCCESS)
						<td class="success">成立</td>
						<td><a href="{{$apl_code_uri}}/message/create/match_id/{{$appointment->match_id}}" class="btn btn-primary btn-sm">返信</a></td>
					@elseif ($appointment->status_id == \App\Appointment::STATUS_ID_NG)
						<td class="danger">否認</td>
						<td><a href="{{$apl_code_uri}}/appointment/{{$appointment->id}}" class="btn btn-default btn-sm">確認</a></td>
					@elseif ($appointment->status_id == \App\Appointment::STATUS_ID_CANCEL)
						<td class="danger">キャンセル</td>
						<td><a href="{{$apl_code_uri}}/appointment/{{$appointment->id}}" class="btn btn-default btn-sm">確認</a></td>
					@endif
				<td>
{{--	
				<td><a href="{{$apl_code_uri}}/appointment/{{$appointment->id}}" class="btn btn-primary btn-sm">詳細</a></td>
					<form method="post" action="{{$apl_code_uri}}/appointment/{{$appointment->id}}">
						 {!! method_field('delete') !!}
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="submit" value="削除" class="btn btn-danger btn-sm btn-destroy">
					</form>
--}}	
				</td>
			</tr>
		@endforeach
	@else
		<tr><td>
		一件もありません。
		</td></tr>
	@endif
	</table>
</div>
@endsection
