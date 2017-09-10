@if ($to_fuser->name)
{{$to_fuser->name}}さん<br />
@endif
{{$apl_name}}の{{$fuser->name}}さんからメッセージがありました。<br />
<br />
{{$text}}<br />
<br />
メッセージ確認<br />
https://{{$domain}}/message/create/match_id/{{$match_id}}<br />
<br />
メッセージ一覧確認<br />
https://{{$domain}}/message<br />
<br />
{{$apl_name}}<br />
https://{{$domain}}/<br />
