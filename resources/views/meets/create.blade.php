@extends('layouts.app')
@section('content')
<div class="container">
    <h1>新規イベント登録</h1>
{{--
    <div class="row">
        <div class="col-sm-12">
            <a href="{{$apl_code_uri}}/meet" class="btn btn-primary" style="margin:20px;">一覧に戻る</a>
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

    <form method="post" action="{{$apl_code_uri}}/meet" class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-4 control-label">日付</label>
			<div class="col-sm-2">
    		<input type="text" name="day" value="{{ old('day', $day) }}" class="form-control datepicker" placeholder="yyyy-mm-dd" />
			</div>
        </div>
        <div class="form-group">
        	<label class="col-sm-4 col-xs-3 control-label">開始時間</label>
			<div class="col-sm-2 col-xs-4">
				<select class="form-control" name="hour">
				@for ($i = 0; $i <= 23; $i++)
				<option @if ($i == old('hour', $hour)) selected @endif value="{{$i}}">{{ substr("0". $i, -2, 2)}}</option>
				@endfor
				</select>
			</div>
			<label class="col-xs-1 control-label">：</label>
			<div class="col-sm-2 col-xs-4">
				<select class="form-control" name="min">
					<option @if (old('min', $min) == 0) selected @endif value="0">00</option>
					<option @if (old('min', $min) == 15) selected @endif >15</option>
					<option @if (old('min', $min) == 30) selected @endif >30</option>
					<option @if (old('min', $min) == 45) selected @endif >45</option>
				</select>
			</div>
        </div>
        <div class="form-group">
        	<label class="col-sm-4 control-label">一回あたりの時間(分)</label>
			<div class="col-sm-2">
				<select class="form-control" name="onemin">
					<option @if (old('onemin') == 30) selected @endif >30</option>
					<option @if (old('onemin') == 60) selected @endif >60</option>
					<option @if (old('onemin') == 90) selected @endif >90</option>
					<option @if (old('onemin') == 120) selected @endif >120</option>
				</select>
			</div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">回数</label>
			<div class="col-sm-2">
				<select class="form-control" name="time">
					@for ($i = 1; $i <= 10; $i++)
					<option @if (old('time') == $i) selected @endif >{{ $i }}</option>
					@endfor
				</select>
			</div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">場所(お店の名前など)</label>
			<div class="col-sm-8">
            <input type="text" name="location_name" value="{{ old('location_name') }}" class="form-control" placeholder="新宿駅前マクドナルドなど" />
			</div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">住所</label>
			<div class="col-sm-8">
            <input type="text" name="location_address" value="{{ old('location_address') }}" class="form-control" placeholder="東京都新宿区など、ビル名は入れないで" />
			</div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label">一言</label>
			<div class="col-sm-11">
            <input type="text" name="text" value="{{ old('text') }}" class="form-control" placeholder="意気込みをどうぞ">
			</div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="submit" value="登録" class="btn btn-primary btn-block">
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="/assets/bootstrap-datepicker-1.6.1-dist/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="/assets/bootstrap-datepicker-1.6.1-dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap-datepicker-1.6.1-dist/locales/bootstrap-datepicker.ja.min.js"></script>
<script type="text/javascript">
$('.datepicker').datepicker({
format: "yyyy-mm-dd",
language: "ja",
autoclose: true
});
</script>



@endsection
