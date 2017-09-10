<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use DB;
class AppointmentcancelController extends Controller
{
	public function __construct()
	{
		$this->_checkUse();
		if (!Session::get('fuser_id')) {
			abort(403, '不正です');
		}
		$this->_checkApl();
	}
	// 申請キャンセル画面
	public function edit($id)
	{
		$appointment = \App\Appointment::find($id);
		if ($appointment->guest_fuser_id != Session::get('fuser_id')) {
			abort(403, "不正です");
		}
		$this->_data['appointment'] = $appointment;
		$this->_data['match'] = \App\Match::find($appointment->match_id);
		$this->_data['meet'] = \App\Meet::find($appointment->meet_id);
		$this->_data['guest_fuser'] = \App\User::findRowExistsById($appointment->guest_fuser_id);
		$this->_data['fuser'] = \App\User::findRowExistsById($appointment->fuser_id);
		return view('appointmentcancels.edit', $this->_data);
	}
	// ゲストによるキャンセル
	public function update(Request $request, $id)
	{
		$appointment = \App\Appointment::find($id);
		if ($appointment->guest_fuser_id != Session::get('fuser_id')) {
			abort(403, "不正です");
		} elseif ($appointment->status_id == \App\Appointment::STATUS_ID_CANCEL) {
			abort(403, '既にキャンセル済みです');
		} elseif ($appointment->status_id != \App\Appointment::STATUS_ID_REQUEST) {
			abort(403, '主催者がステータスを更新したためキャンセルできませんでした。');
		}
		$this->validate($request, [
			'text' => 'required|max:255',
		]);
		$match = \App\Match::find($appointment->match_id);
		$meet = \App\Match::find($appointment->meet_id);
		$guest_fuser = \App\User::findRowExistsById($appointment->guest_fuser_id);
		$appointment->status_id = \App\Appointment::STATUS_ID_CANCEL;
		$appointment->cancel_text = $request->text;
		$appointment->save();

		$message = \App\Message::create();
		$message->match_id = $appointment->match_id;
		$message->meet_id = $appointment->meet_id;
		$message->fuser_id = Session::get('fuser_id');
		$message->to_fuser_id = $appointment->fuser_id;
		$message->text = $request->text;
		$message->appointment_status_id = \App\Appointment::STATUS_ID_CANCEL;
		$message->save();
		$fuser = \App\User::findRowExistsById($appointment->fuser_id);
		if (!$fuser) {
			abort(403, "相手がいません");
		}
		$fuser->new_message_cnt += 1;
		$fuser->save();
		$match->appointment_cnt = \App\Appointment::countRequestSuccessByMatchId($appointment->match_id);
		$match->save();
		app('App\Services\EmailSend')
			->appointmentByFuserIdToFuserIdTextMeetIdMatchIdAppointmentIdStatusId(
				Session::get('fuser_id'),
				$appointment->fuser_id,
				$request->text,
				$appointment->meet_id,
				$appointment->match_id,
				$id,
				\App\Appointment::STATUS_ID_CANCEL
			);
		return redirect()->to($this->_apl_code_uri.'/appointment/'.$appointment->id);
	}
}
