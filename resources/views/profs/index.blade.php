@extends('layouts.app')
@section('content')
<div class="container">
	<h1>メンバーリスト</h1>

	<div class="row">
	@foreach($fusers as $key => $fuser)
		<div class="col-sm-6 col-md-4" style="padding-bottom:5px">
			<div class="row">
				@if ($fuser)
				<div class="col-xs-4">
					<a href="{{$apl_code_uri}}/prof/{{$fuser->id}}"><img class="thumbnail" src="{{$fuser->avatar}}" width="100px" height="100px" /></a>
					<h5>{{$fuser->name}}</h5>
				</div>
				<div class="col-xs-8">
					入会日：{{substr($fuser->created_at,0,10)}}<br />
					{{$fuser->text}}<br />
					@if ($fuser->location)
					場所：{{$fuser->location}}<br />
					@endif
					@if ($fuser->tag)
					タグ：{{$fuser->tag}}<br />
					@endif
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


</div>
@endsection
