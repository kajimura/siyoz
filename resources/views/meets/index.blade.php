@extends('layouts.app')
@section('content')
<div class="container">
    <h1>イベント一覧</h1>
{{--
    <div class="row">
        <div class="col-sm-12">
            <a href="{{$apl_code_uri}}/meet/create" class="btn btn-primary" style="margin:20px;">新規登録</a>
        </div>
    </div>
--}}
	@if (count($meets))
		@include('_parts/meet_index')
	@else
		<table class="table table-striped">
			<tr>
				<td>イベント</td>
				<td></td>
			</tr>
			<td>
				現在イベントは一件もありません。
			</td>
		</table>
	@endif
</div>
@endsection
