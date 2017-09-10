@extends('layouts.app')

@section('content')

<div class="container">

<h2>
{{$body_title}}
</h2>
{!!$body!!}

@if (count($pages))
<br />
<br />
<div align="center">
@foreach($pages as $page)
@if ($page['code'] != $code)
<a href="{{$apl_code_uri}}/blog/{{$page['code']}}">{{$page['name']}}</a> |
@endif
@endforeach
</div>
@endif

</div>

@endsection



