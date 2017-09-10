@extends('layouts.app')
@section('content')
<div class="container">
    <h1>一覧表示</h1>
    <table class="table table-striped">
    @foreach($matches as $match)
        <tr>
			@if (isset($match->meet))
            <td>{{$match->meet->id}}</td>
            <td>{{$match->meet->location_name}}</td>
            <td>{{$match->meet->location_address}}</td>
            <td>{{$match->meet->day}}</td>
            <td>{{ substr($match->start_time, 0, 5) }}</td>
            <td>{{ substr($match->end_time, 0, 5) }}</td>
            <td><a href="{{$apl_code_uri}}/match/{{$match->id}}" class="btn btn-primary btn-sm">詳細</a></td>
            <td><a href="{{$apl_code_uri}}/match/{{$match->id}}/edit" class="btn btn-primary btn-sm">編集</a></td>
            <td>
                <form method="post" action="{{$apl_code_uri}}/match/{{$match->id}}">
                     {!! method_field('delete') !!}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="submit" value="削除" class="btn btn-danger btn-sm btn-destroy">
                </form>
            </td>
			@endif
        </tr>
    @endforeach
    </table>
</div>
@endsection
