@if ($to_fuser->name)
{{$to_fuser->name}}さん<br />
@endif
{{$apl_name}}の{{$fuser->name}}さんから{{$status_name}}がありました。<br />
<br />
{{$status_name}}メッセージ<br />
{{$text}}<br />
<br />
申請確認<br />
https://{{$domain}}/appointment/{{$appointment_id}}<br />
<br />
申請受信一覧<br />
https://{{$domain}}/appointment<br />
<br />
{{$apl_name}}<br />
https://{{$domain}}/<br />
