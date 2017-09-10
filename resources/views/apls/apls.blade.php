@extends('layouts.app')
@section('content')
<div class="container">
	<h1>作成した待ち合わせWebサイト</h1>

	<div class="row">
	@foreach($apls as $key => $apl)
		<div class="col-sm-6 col-md-4" style="padding-bottom:5px">
			<div class="row">
				@if ($apl)
				<div class="col-xs-4">
					{{$apl->name}}<br />
					<a href="/apl/{{$apl->id}}/edit">edit</a> |
					<a href="/{{$apl->code}}">view</a>

				</div>
				<div class="col-xs-8">
					http://siyoz.net/{{$apl->code}}<br />
					作成日：{{substr($apl->created_at,0,10)}}<br />
					{{$apl->description}}<br />
				</div>
				@else
				<div class="col-xs-4">
				</div>
				<div class="col-xs-8">
					システムがありません。<br />
				</div>
				@endif
			</div>
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
<hr />
		<div class="form-group">
			<label for="text">
				待ち合わせWebサイト新規作成
			</label>
	<a href="/apl/create" class="btn btn-primary btn-block">新規作成</a>
		</div>


</div>
@endsection
