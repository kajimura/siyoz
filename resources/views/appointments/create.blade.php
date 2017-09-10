@extends('layouts.app')
@section('content')
<div class="container">
	<h1>申請</h1>
{{--
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/match/{{$match->id}}" class="btn btn-primary" style="margin:20px;">戻る</a>
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
					{{$fuser->name}}
				</div>
				<div class="col-sm-12">
					{{$meet->text}}
				</div>
			</div>
		</div>
	</div>
	@if ($appointment)
		既に申請済みです<br />
		{{$appointment->text}}
	@else
	<form method="post" action="{{$apl_code_uri}}/appointment">
		<input type="hidden" name="match_id" value="{{$match->id}}" />
		<div class="form-group">
			<label>申請メッセージ</label>
			<input type="text" name="text" value="" class="form-control">
		</div>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="submit" value="申請" class="btn btn-primary">
	</form>
	@endif
</div>
@endsection
