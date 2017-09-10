<?php
/*
$send = app('App\EmailSend');
$send->registByFuserId(1);
*/
namespace App\Services;
class EmailSend
{
	private $_domain = "poke.siyoz.net";
	private $_apl_name = "ポケモンGOしようぜ";
	private $_code;
	public function __construct()
	{
		$apl = app('App\Services\Apl');
		$this->_apl_name = $apl->getName();
		$this->_domain = $apl->getDomain();
		$this->_code = $apl->getCode();
	}
	// アカウント登録
	public function registByFuserId($fuser_id)
	{
		$fuser = \App\User::find($fuser_id);
		// $email = "masahiko.kajimura@gmail.com"; // @yahoo.co.jp";
		// $email = $fuser->email;
		$title = $this->_apl_name . "会員情報のお知らせ";
/*
$text =<<<EOD
ポケモンGOしようぜ会員情報をお知らせします。

facebookアカウント
{$email}

プロフ登録
http://poke.siyoz.net/myaccount/profedit

ポケモンGOしようぜ
http://poke.siyoz.net/
EOD;
*/
		$data = [
			'fuser' => $fuser
		];
		$this->_exec($data, $title, "mails/regist");
	}
	public function messageByFuserIdToFuserIdTextMeetIdMatchId(
			$fuser_id, $to_fuser_id, $text, $meet_id, $match_id)
	{
		$fuser = \App\User::find($fuser_id);
		$to_fuser = \App\User::find($to_fuser_id);
		$title = $to_fuser['name'] . "さんからメッセージがありました";
		$data = [
			'fuser' => $fuser,
			'to_fuser' => $to_fuser,
			'text' => $text,
			'meet_id' => $meet_id,
			'match_id' => $match_id
		];
		$this->_exec($data, $title, "mails/message");
	}
	// 申請送信(申請/キャンセル)
	public function appointmentByFuserIdToFuserIdTextMeetIdMatchIdAppointmentIdStatusId(
			$fuser_id, $to_fuser_id, $text, $meet_id, $match_id, $appointment_id, $status_id)
	{
		$fuser = \App\User::find($fuser_id);
		$to_fuser = \App\User::find($to_fuser_id);
		$status_name = \App\Appointment::getStatusNameByStatusId($status_id);
		$title = $to_fuser['name'] . "さんから".$status_name."がありました";
		$data = [
			'fuser' => $fuser,
			'to_fuser' => $to_fuser,
			'text' => $text,
			'meet_id' => $meet_id,
			'match_id' => $match_id,
			'appointment_id' => $appointment_id,
			'status_name' => $status_name,
		];
		$this->_exec($data, $title, "mails/appointment");
	}
	// 申請結果(否認/承認)
	public function appointmentResultByFuserIdToFuserIdTextMeetIdMatchIdAppointmentIdStatusId(
			$fuser_id, $to_fuser_id, $text, $meet_id, $match_id, $appointment_id, $status_id)
	{
		$fuser = \App\User::find($fuser_id);
		$to_fuser = \App\User::find($to_fuser_id);
		$title = $to_fuser['name'] . "さんから申請結果がありました";
		$status_name = \App\Appointment::getStatusNameByStatusId($status_id);
		$data = [
			'fuser' => $fuser,
			'to_fuser' => $to_fuser,
			'text' => $text,
			'meet_id' => $meet_id,
			'match_id' => $match_id,
			'appointment_id' => $appointment_id,
			'status_name' => $status_name,
		];
		$this->_exec($data, $title, "mails/appointmentresult");
	}
	private function _exec($data, $title, $view)
	{
		if ($this->_domain == "siyoz.net") {
			$data['domain'] = $this->_domain;
		} else {
			$data['domain'] = $this->_domain ."/". $this->_code;
		}
		$data['apl_name'] = $this->_apl_name;
		\Mail::send($view, $data, 
			function ($m) use ($data, $title) {
				$m->from(\Config::get('mail.username'), $this->_apl_name);
				if (array_key_exists('to_fuser', $data) && $data['to_fuser']) {
					$m->to($data['to_fuser']->email, $data['to_fuser']->email)->subject($title);
				} else {
					$m->to($data['fuser']->email, $data['fuser']->email)->subject($title);
				}
		});
	}
}
