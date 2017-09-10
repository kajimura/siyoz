@extends('layouts.app')
@section('content')
<div class="container">
	<h1>詳細表示</h1>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{$apl_code_uri}}/fuser" class="btn btn-primary" style="margin:20px;">一覧に戻る</a>
		</div>
	</div>
	<table class="table table-striped">
		<tr><td>ID</td><td>{{$fuser->id}}</tr>
		<tr><td>名前</td><td>{{$fuser->name}}</tr>
		<tr><td>E-Mail</td><td>{{$fuser->email}}</tr>
	</table>
</div>
@endsection
