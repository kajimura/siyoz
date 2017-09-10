@extends('layouts.app')
@section('content')
<div class="container">
    <h1>時間編集</h1>
{{--
    <div class="row">
        <div class="col-sm-12">
            <a href="{{$apl_code_uri}}/match" class="btn btn-primary" style="margin:20px;">一覧に戻る</a>
        </div>
    </div>
--}}
	<table>
        <tr><td>場所</td><td>{{$meet->location_name}}</tr>
        <tr><td>住所</td><td>{{$meet->location_address}}</tr>
        <tr><td>日付</td><td>{{$meet->day}}</tr>
        <tr><td>一言</td><td>{{$meet->text}}</tr>
	</table>
	@if ($match->guest_fuser)
        <tr><td>ゲスト</td><td>{{$match->guest_fuser->name}}</tr>
	@endif
    <form method="post" action="{{$apl_code_uri}}/match/{{$match->id}}">
        {!! method_field('put') !!}
        <div class="form-group">
            <label>開始時間</label>
            <input type="text" name="start_time" value="{{$match->start_time}}" class="form-control">
        </div>
        <div class="form-group">
            <label>終了時間</label>
            <input type="text" name="end_time" value="{{$match->end_time}}" class="form-control">
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="submit" value="更新" class="btn btn-primary">
    </form>
</div>
@endsection

