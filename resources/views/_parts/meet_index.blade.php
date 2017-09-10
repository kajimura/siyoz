	<div class="row">
	@foreach($meets as $key => $meet)
		<div class="col-sm-6 col-md-4" style="padding-bottom:5px">
			<div class="row">
				@if ($meet->fuser)
				<div class="col-xs-4">
					<a href="{{$apl_code_uri}}/prof/{{$meet->fuser->id}}"><img class="thumbnail" src="{{$meet->fuser->avatar}}" width="100px" height="100px" /></a>
				</div>
				<div class="col-xs-8">
					{{$meet->fuser->name}}<br />
					{{$meet->fuser->text}}<br />
				</div>
				@else
				<div class="col-xs-4">
				</div>
				<div class="col-xs-8">
					メンバーがいません<br />
					メンバーが退会しました。<br />
				</div>
				@endif
			</div>
			<div class="row">
				<div class="col-xs-12">
					<a href="{{$apl_code_uri}}/meet/{{$meet->id}}" class="btn-default btn-block" style="border:1px solid #ccc;padding:5px;margin-bottom:5px">
					<h3>{{$meet->day}}</h3>
					{{$meet->location_name}}<br />
					{{$meet->location_address}}<br />
					{{$meet->text}}<br />
					</a>
				</div>
			</div>
			<table class="table table-striped">
				@if ($meet->matches)
					@foreach ($meet->matches as $match)
						@if ($match->start_time && $match->end_time)
							<tr><td>
							{{ substr($match->start_time, 0, 5) }}〜{{ substr($match->end_time, 0, 5) }}
							</td><td>
								@if ($match->guest_fuser)
									<a href="{{$apl_code_uri}}/prof/{{$match->guest_fuser->id}}">
									<img src="{{$match->guest_fuser->avatar}}" width="30px" height="30px" />
									</a>
								@endif
							</td><td>
							@if (preg_match("/before/", $match->msg_diff))
								<a class="btn btn-default btn-sm btn-block" href="{{$apl_code_uri}}/match/{{$match->id}}">終了</a>
							@elseif ($match->guest_fuser_id)
								<a class="btn btn-success btn-sm btn-block" href="{{$apl_code_uri}}/match/{{$match->id}}">成立</a>
							@else
								<a class="btn btn-primary btn-sm btn-block" href="{{$apl_code_uri}}/match/{{$match->id}}">募集中</a>
							@endif
							</td></tr>
						@endif
					@endforeach
				@endif
			</table>
{{--
			<td><a href="{{$apl_code_uri}}/meet/{{$meet->id}}/edit" class="btn btn-primary btn-sm">編集</a></td>
			<td>
				<form method="post" action="{{$apl_code_uri}}/meet/{{$meet->id}}">
					 {!! method_field('delete') !!}
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="submit" value="削除" class="btn btn-danger btn-sm btn-destroy">
				</form>
			</td>
--}}
		</div>
		@if ($key % 3 == 2)
		<div class="clearfix visible-lg-block"></div>
		<div class="clearfix visible-md-block"></div>
		@endif
		@if ($key % 2 == 1)
		<div class="clearfix visible-sm-block"></div>
		@endif
	@endforeach
	</div>
