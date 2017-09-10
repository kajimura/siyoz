@extends('layouts.app')
@section('content')
<div class="container">
    <h1>新規作成</h1>
    <div class="row">
        <div class="col-sm-12">
            <a href="{{$apl_code_uri}}/meet" class="btn btn-default" style="margin:20px;">一覧に戻る</a>
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

	<table>
        <tr><td>場所</td><td>{{$meet->location_name}}</td></tr>
        <tr><td>住所</td><td>{{$meet->location_address}}</td></tr>
        <tr><td>日付</td><td>{{$meet->day}}</td></tr>
        <tr><td>一言</td><td>{{$meet->text}}</td></tr>
	</table>
    <form method="post" action="{{$apl_code_uri}}/match" class="form-horizontal">
        <input type="hidden" name="meet_id" value="{{$meet->id}}">
        <div class="form-group">
        	<label class="col-sm-4 col-xs-4 control-label">開始時間</label>
			<div class="col-sm-2 col-xs-2">
				<select class="form-control" name="hour">
				@for ($i = 0; $i <= 23; $i++)
				<option @if ($i == $hour) selected @endif >{{ substr("0". $i, -2, 2)}}</option>
				@endfor
				</select>
			</div>
			<label class="col-xs-1 control-label">：</label>
			<div class="col-sm-2 col-xs-2">
				<select class="form-control" name="min">
				<option @if ($min == 0) selected @endif >00</option>
				<option @if ($min == 15) selected @endif >15</option>
				<option @if ($min == 30) selected @endif >30</option>
				<option @if ($min == 45) selected @endif >45</option>
				</select>
			</div>
		</div>
        <div class="form-group">
        	<label class="col-sm-4 control-label">一回あたりの時間(分)</label>
			<div class="col-sm-2">
				<select class="form-control" name="onemin">
					<option>30</option>
					<option selected>60</option>
					<option>90</option>
					<option>120</option>
				</select>
			</div>
        </div>
{{--
        <div class="form-group">
        	<label class="col-sm-4 col-xs-4 control-label">終了時間</label>
			<div class="col-sm-2 col-xs-4">
				<select class="form-control" name="end_hour">
				@for ($i = 0; $i <= 23; $i++)
				<option @if ($i == $hour) selected @endif >{{ substr("0". $i, -2, 2)}}</option>
				@endfor
				</select>
			</div>
			<div class="col-sm-2 col-xs-4">
				<select class="form-control" name="end_min">
				<option>00</option>
				<option>15</option>
				<option selected>30</option>
				<option>45</option>
				</select>
			</div>
        </div>
--}}
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="submit" value="追加" class="btn btn-primary">
    </form>
</div>
@endsection
