@extends('layouts.app')
@section('content')
<div class="container">
{{--
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/meet" class="btn btn-default" style="margin:20px;">一覧に戻る</a>
		</div>
	</div>
--}}
	<div class="row thumbnail">
		<div class="col-sm-3">
			<div class="row">
				<div class="col-sm-12">
					@if ($fuser)
					<a href="{{$apl_code_uri}}/prof/{{$fuser->id}}">
						<img src="{{$fuser->avatar_original}}" width="300px" />
					</a>
					@else
						メンバーが存在しません
					@endif
					<br /><br />
				</div>
			@if ($self_fuser_id == $meet->fuser_id)
				<div class="col-xs-6">
					<a href="{{$apl_code_uri}}/meet/{{$meet->id}}/edit" class="btn btn-default btn-sm">イベント編集</a><br />
				</div>
				<div class="col-xs-6">
				<form method="post" action="{{$apl_code_uri}}/meet/{{$meet->id}}">
					 {!! method_field('delete') !!}
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="submit" value="この日のイベントを全削除" class="btn btn-default btn-sm btn-destroy" onclick="return window.confirm('本当に削除してよろしいですか？')" />
				</form>
				</div>
			@endif
			</div>
		</div>
		<div class="col-sm-9">
			<div style="font-size:50px">{{$meet->day}}</div>
			<div class="row">
				<div class="col-sm-12">
					{{$meet->location_name}}
				</div>
				<div class="col-sm-12">
					{{$meet->location_address}}
					(<a href="https://www.google.co.jp/maps/place/{{$meet->lat}},{{$meet->lng}}/@\{{$meet->lat}},{{$meet->lng}},18z?hl=ja" target="_blank">地図</a>)
				</div>
			</div>
			@if ($fuser)
			{{$fuser->text}}<br />
			@else
			メンバーが存在しません<br />
			@endif
			{{$meet->text}}<br />
			<br />
		</div>
	</div>
<br />


	<table class="table table-striped">
	@foreach($meet->matches as $match)
		<tr>
			@if (isset($match->meet) && $match->start_time || $match->end_time)
				<td>{{ substr($match->start_time, 0, 5) }}〜{{ substr($match->end_time, 0, 5) }}</td>
				<td>申請数:{{$match->appointment_cnt}}人</td>
					<td>
								@if ($match->guest_fuser_id)
									<a href="{{$apl_code_uri}}/prof/{{$match->guest_fuser->id}}">
									<img src="{{$match->guest_fuser->avatar}}" width="30px" height="30px" />
									</a>
								@endif
							</td><td>
							@if (preg_match("/before/", $match->msg_diff))
								<a class="btn btn-default btn-sm btn-block" href="{{$apl_code_uri}}/match/{{$match->id}}">終了</a>
							@elseif ($match->guest_fuser_id)
								<a class="btn btn-success btn-sm btn-block" href="{{$apl_code_uri}}/match/{{$match->id}}">成
立</a>
							@else
								<a class="btn btn-primary btn-sm btn-block" href="{{$apl_code_uri}}/match/{{$match->id}}">募
集中</a>
							@endif
					</td>
{{--
				@if ($self_fuser_id == $match->meet->fuser_id)
					<td><a href="{{$apl_code_uri}}/match/{{$match->id}}/edit" class="btn btn-default btn-sm">編集</a></td>
					<td>
						<form method="post" action="{{$apl_code_uri}}/match/{{$match->id}}">
							 {!! method_field('delete') !!}
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="submit" value="削除" class="btn btn-default btn-sm btn-destroy" onclick="return window.confirm('本当に削除してよろしいですか？')">
						</form>
					</td>
				@endif
--}}
			@endif
		</tr>
	@endforeach
	</table>

	@if ($self_fuser_id == $meet->fuser_id)
		@if (preg_match("/after/", $before_after))
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/match/create/meet_id/{{$meet->id}}" class="btn btn-default" style="margin:20px;">時間の新規登録</a>
		</div>
	</div>
		@endif
	@endif
<div class="row">
<div class="col-md-4 col-sm-6 col-xs-12">
<a href="https://www.google.co.jp/maps/place/{{$meet->lat}},{{$meet->lng}}/@\{{$meet->lat}},{{$meet->lng}},18z?hl=ja" target="_blank">
<img src="https://maps.googleapis.com/maps/api/staticmap?center={{$meet->lat}}%2c%20{{$meet->lng}}&size=400x400&zoom=15&sensor=false&key=AIzaSyAYWMBB4Zom5YHMpN8Yg6GttjeD2IGOcI8&markers={{$meet->lat}},{{$meet->lng}}"  width="100%" />
</a>
</div>
</div>
{{--
<div id="map-canvas"></div>
@include('_parts/mapjs')
</div>
--}}

@endsection
