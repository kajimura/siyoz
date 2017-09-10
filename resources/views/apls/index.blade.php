@extends('layouts.app')
@section('content')
<div class="container">
{{--
	<h1>待ち合わせWebサイト作成サービス</h1>
--}}
<div class="row">
<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">{{$apl_name}}とは</div>
				<div class="panel-body">
					<img src="/assets/img/top/mac_baby.jpg" width="100%" /><br />
					1対1の待ち合わせに適したWebサイトを作成できるサービスです。
				</div>
			</div>
</div>
<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">サンプルサイト</div>
				<div class="panel-body">
					<img src="/assets/img/top/girl_wait2.jpg" width="100%" /><br />
					<a href="/sample">サンプル1サイト</a><br />
				</div>
			</div>
</div>
<div class="clearfix visible-lg-block"></div>
<div class="clearfix visible-md-block"></div>
<div class="clearfix visible-sm-block"></div>

<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">待ち合わせWebサイト作成サービスで作ったサイト</div>
				<div class="panel-body">
					<img src="/assets/img/top/girl_wait.jpg" width="100%" /><br />
					<a href="https://poke.siyoz.net/">ポケモンGOしようぜ(ポケモンGO待ち合わせ)</a><br />
					<a href="https://game.siyoz.net/">ゲーオフ(ゲームセンター待ち合わせ)</a><br />
				</div>
			</div>
</div>
<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">まずはFacebookによる事前登録</div>
				<div class="panel-body">
					<img src="/assets/img/top/baby.jpg" width="100%" /><br />
					Facebook認証で確認いたします。<br />
				</div>
			</div>
</div>
<div class="clearfix visible-lg-block"></div>
<div class="clearfix visible-md-block"></div>
<div class="clearfix visible-sm-block"></div>

<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">イベント登録</div>
				<div class="panel-body">
					<img src="/assets/img/top/meet_create.jpg" width="100%" /><br />
					イベントを登録<br />
					30〜120分までの間で設定。まとめての登録も可能です。<br />
				</div>
			</div>
</div>
<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">イベント一覧確認</div>
				<div class="panel-body">
					<img src="/assets/img/top/meet_index.jpg" width="100%" /><br />
					他の人が登録したイベントを確認できます。募集中のあるイベントを選択しましょう。
				</div>
			</div>
</div>
<div class="clearfix visible-lg-block"></div>
<div class="clearfix visible-md-block"></div>
<div class="clearfix visible-sm-block"></div>

<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">イベント登録</div>
				<div class="panel-body">
					<img src="/assets/img/top/meet_create.jpg" width="100%" /><br />
					イベントを登録<br />
					30〜120分までの間で設定。まとめての登録も可能です。<br />
				</div>
			</div>
</div>
<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">イベント一覧確認</div>
				<div class="panel-body">
					<img src="/assets/img/top/meet_index.jpg" width="100%" /><br />
					他の人が登録したイベントを確認できます。募集中のあるイベントを選択しましょう。
				</div>
			</div>
</div>

<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">申請が成立すれば</div>
				<div class="panel-body">
					<img src="/assets/img/top/message_show.jpg" width="100%" /><br />
					お互いにメッセージを送信することができます。
				</div>
			</div>
</div>
<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">複数のメッセージを一覧で確認できます</div>
				<div class="panel-body">
					<img src="/assets/img/top/message_index.jpg" width="100%" /><br />
					メッセージをもれなく確認<br />
				</div>
			</div>
</div>
<div class="clearfix visible-lg-block"></div>
<div class="clearfix visible-md-block"></div>
<div class="clearfix visible-sm-block"></div>
{{--
<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">夜間の散歩はお気をつけを</div>
				<div class="panel-body">
					<img src="/assets/img/top/poke/girl_walk.jpg" width="100%" /><br />
					お早めに帰りましょう。<br />
				</div>
			</div>
</div>
<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">歩きスマホはくれぐれもお気をつけを</div>
				<div class="panel-body">
					<img src="/assets/img/top/poke/ojisan.jpg" width="100%" /><br />
					歩きスマホは注意しましょう
				</div>
			</div>
</div>
<div class="clearfix visible-lg-block"></div>
<div class="clearfix visible-md-block"></div>
<div class="clearfix visible-sm-block"></div>
--}}

<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">各種プラン</div>
		<div class="panel-body">
			<table class="table table-striped">
			<tr>
				<th>プラン</th>
				<th>登録人数</th>
				<th>料金</th>
			</tr>
			<tr>
				<td>フリー</td>
				<td>10人</td>
				<td>無料</td>
			</tr>
			<tr>
				<td>有料(comming soon)</td>
				<td>50人</td>
				<td>3000円/月</td>
			</tr>
			</table>
		</div>
	</div>
</div>
<div class="clearfix visible-lg-block"></div>
<div class="clearfix visible-md-block"></div>
<div class="clearfix visible-sm-block"></div>
</div>

<p>
<a href="{{$apl_code_uri}}/facebook" class="btn btn-block btn-lg" style="background-color:#3c5d96;color:#fff">
facebookアカウントでサイトを新規作成 (21歳以上)</a>
</p>


</div>
@endsection
