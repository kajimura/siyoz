<?php
namespace App\Services;
class Message
{
	public function getObjectsByRecords($messages)
	{
		$fusers = [];
		$meets = [];
		$matches = [];
		foreach ($messages as $message) {
			// 何度も取得しないように
			if (array_key_exists($message->match_id, $matches)) {
				$message->match = $matches[$message->match_id];
			} else {
				$match = \App\Match::find($message->match_id);
				$matches[$message->match_id] = $match;
				$message->match = $match;
			}
			if (array_key_exists($message->meet_id, $meets)) {
				$message->meet = $meets[$message->meet_id];
			} else {
				$meet = \App\Meet::find($message->meet_id);
				$meets[$message->meet_id] = $meet;
				$message->meet = $meet;
			}
			if (array_key_exists($message->fuser_id, $fusers)) {
				$message->fuser = $fusers[$message->fuser_id];
			} else {
				$fuser = \App\User::find($message->fuser_id);
				$fusers[$message->fuser_id] = $fuser;
				$message->fuser = $fuser;
			}
			$status_msg = "";
			if ($message->appointment_status_id == \App\Appointment::STATUS_ID_REQUEST) {
				$status_msg = "[申請しました] ";
			} elseif ($message->appointment_status_id == \App\Appointment::STATUS_ID_SUCCESS) {
				$status_msg = "[マッチング成功しました] ";
			} elseif ($message->appointment_status_id == \App\Appointment::STATUS_ID_NG) {
				$status_msg = "[否認されました] ";
			}
			$message->status_msg = $status_msg;
		}
		return $messages;
	}
}
