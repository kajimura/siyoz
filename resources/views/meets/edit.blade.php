@extends('layouts.app')
@section('content')
<div class="container">
    <h1>情報編集</h1>
    <div class="row">
        <div class="col-sm-12">
            <a href="{{$apl_code_uri}}/meet/{{$meet->id}}" class="btn btn-default" style="margin:20px;">戻る</a>
        </div>
    </div>
<div class="alert alert-info">
成立している場合の変更は必ずゲストに連絡しましょう。
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
    <form method="post" action="{{$apl_code_uri}}/meet/{{$meet->id}}" class="form-horizontal">
        {!! method_field('put') !!}
        <div class="form-group">
            <label class="col-sm-4 control-label">日付</label>
			<div class="col-sm-2">
    		<input type="text" name="day" value="{{ old('day', $meet->day) }}" class="form-control datepicker" placeholder="yyyy/mm/dd" />
			</div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">場所(お店の名前など)</label>
			<div class="col-sm-8">
            <input type="text" name="location_name" value="{{ old('location_name', $meet->location_name) }}" class="form-control" placeholder="スタバなど" />
			</div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">住所</label>
			<div class="col-sm-8">
            <input type="text" name="location_address" value="{{ old('location_address', $meet->location_address) }}" class="form-control" placeholder="東京都新宿区>など、ビル名は入れないで" />
			</div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label">一言</label>
			<div class="col-sm-11">
            <input type="text" name="text" value="{{ old('text', $meet->text) }}" class="form-control" placeholder="意気込みをどうぞ">
			</div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="submit" value="更新" class="btn btn-primary">
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

