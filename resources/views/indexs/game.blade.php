@extends('layouts.app')

@section('content')

@include('indexs/_game_carousel')
<div class="container">
{{--
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
            </div>
        </div>
    </div>
--}}
<div class="row">
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">{{$apl_name}}とは</div>
                <div class="panel-body">
					<img src="/assets/img/top/game/tranp.jpg" width="100%" /><br />
					ゲームセンター内のゲーム機の1対1のリアル待ち合わせサイトです
				</div>
			</div>
</div>
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">まずはFacebookによる事前登録</div>
                <div class="panel-body">
					<img src="/assets/img/top/game/kinsi.jpg" width="100%" /><br />
					Facebook認証で確認いたします。<br />
					21歳未満のご使用はできません。<br />
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
                <div class="panel-heading">イベントの詳細を確認</div>
                <div class="panel-body">
					<img src="/assets/img/top/meet_show.jpg" width="100%" /><br />
					Facebookページなどで人柄を確認して、
					スケジュールが合えば申請します。
					事前に地図を確認しておきましょう<br />
				</div>
			</div>
</div>
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">相手の申請を待ちます</div>
                <div class="panel-body">
					<img src="/assets/img/top/appointment_index.jpg" width="100%" /><br />
					リクエスト中・承認・否認・キャンセルなどのステータスがあります。<br />
				</div>
			</div>
</div>
<div class="clearfix visible-lg-block"></div>
<div class="clearfix visible-md-block"></div>
<div class="clearfix visible-sm-block"></div>
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
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">将棋会所</div>
                <div class="panel-body">
					<img src="/assets/img/top/game/shogi.jpg" width="100%" /><br />
					将棋会所での対戦などでもOK!<br />
				</div>
			</div>
</div>
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">麻雀所</div>
                <div class="panel-body">
					<img src="/assets/img/top/game/majan.jpg" width="100%" /><br />
					麻雀所での対戦などでもOK!<br />
				</div>
			</div>
</div>
<div class="clearfix visible-lg-block"></div>
<div class="clearfix visible-md-block"></div>
<div class="clearfix visible-sm-block"></div>
</div>

<p>
<a href="{{$apl_code_uri}}/facebook" class="btn btn-block btn-lg" style="background-color:#3c5d96;color:#fff">
facebookで登録 (21歳以上)</a>
</p>

@include('_parts/meet_index')

<div class="row">
<div class="col-md-12">
<p>
<a href="{{$apl_code_uri}}/facebook" class="btn btn-block btn-lg" style="background-color:#3c5d96;color:#fff">
facebookで登録 (21歳以上)</a>
</p>
<div align="center">
ユーザーの許可なくfacebookに投稿することはありません
</div>
</div>
<hr />
@include('_parts/facebook_likebox')
</div>



@endsection
