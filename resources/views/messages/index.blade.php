@extends('layouts.app')
@section('content')
<div class="container">
	<h1>メッセージ一覧</h1>
{{--
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/message/create" class="btn btn-primary" style="margin:20px;">新規登録</a>
		</div>
	</div>
--}}

	<table class="table table-striped">
			<tr>
				<td>送信者</td>
				<td>メッセージ</td>
				<td></td>
			</tr>
	@if (count($messages))
		@foreach($messages as $message)
			<tr>
				@if ($message->fuser && $message->fuser->del_flag == 0)
				<td><a href="{{$apl_code_uri}}/prof/{{$message->fuser->id}}"><img src="{{$message->fuser->avatar}}" width="50px" height="50px" /></a><br />
					<span style="color:gray;font-size:10px">{{$message->fuser->name}}</span>
				</td>
				@else
				<td>ユーザは退会しました</td>
				@endif
				@if ($message->meet)
					<td>
{{--
					<a href="{{$apl_code_uri}}/meet/{{$message->meet->id}}"></a>
--}}
						@if ($message->status_msg)
							{{$message->status_msg}}
						@endif
						{{$message->text}}<br />
						<span style="color:gray;font-size:10px">{{$message->created_at}}</span><br />
						@if ($message->match)
							<span style="font-size:10px">
							<a href="{{$apl_code_uri}}/match/{{$message->match->id}}">
							{{$message->meet->day}}
							{{ substr($message->match->start_time, 0, 5) }}〜{{ substr($message->match->end_time, 0, 5) }}
							</a>
							</span>
						@endif
					</td>
					@if ($message->match)
						@if ($message->match->guest_fuser_id)
							<td><a href="{{$apl_code_uri}}/message/create/match_id/{{$message->match->id}}" class="btn btn-primary btn-sm">返信</a></td>
	{{--
						@elseif ($message->appointment_status_id == \App\Appointment::STATUS_ID_NG)
	--}}
						@endif
					@endif
				@endif
	{{--
				<td><a href="{{$apl_code_uri}}/message/{{$message->id}}/edit" class="btn btn-primary btn-sm">編集</a></td>
				<td>
					<form method="post" action="{{$apl_code_uri}}/message/{{$message->id}}">
						 {!! method_field('delete') !!}
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="submit" value="削除" class="btn btn-danger btn-sm btn-destroy">
					</form>
				</td>
	--}}
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
