@if ($to_fuser->name)
{{$to_fuser->name}}さん<br />
@endif
{{$apl_name}}の{{$fuser->name}}さんから申請結果がありました。<br />
[{{$status_name}}]<br />
<br />
申請結果メッセージ<br />
{{$text}}<br />
<br />
申請結果確認<br />
https://{{$domain}}/appointment/{{$appointment_id}}<br />
<br />
申請送信一覧<br />
https://{{$domain}}/appointment/indexrequest<br />
<br />
{{$apl_name}}<br />
https://{{$domain}}/<br />
