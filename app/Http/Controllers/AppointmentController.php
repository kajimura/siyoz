<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use DB;
class AppointmentController extends Controller
{
	public function __construct()
	{
		$this->_checkUse();
		if (!Session::get('fuser_id')) {
			abort(403, '不正です');
		}
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$user) {
			abort(403, "あなたは会員ではありません");
		}
		$this->_checkApl();
		$this->_checkAplSessionUser();
	}
	// 申請を受けたものの一覧を表示
	public function index()
	{
		if (!Session::get('fuser_id')) {
			abort(403, '不正です');
		}
		$appointments = \App\Appointment::findAllByFuserId(Session::get('fuser_id'));
		$appointments = app('App\Services\Appointment')->getObjectsByRecords($appointments);
		$this->_data['appointments'] = $appointments;
		// 申請のnew_Flagを消す
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		$fuser->new_appointment_cnt = 0;
		$fuser->save();
		return view('appointments.index', $this->_data);
	}
	// 申請を送信したものの一覧を表示
	public function indexrequest()
	{
		if (!Session::get('fuser_id')) {
			abort(403, '不正です');
		}
		$appointments = \App\Appointment::findAllByGuestFuserId(Session::get('fuser_id'));
		$appointments = app('App\Services\Appointment')->getObjectsByRecords($appointments);
		$this->_data['appointments'] = $appointments;
		// 申請のnew_Flagを消す
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		$fuser->new_appointment_cnt = 0;
		$fuser->save();
		return view('appointments.indexrequest', $this->_data);
	}
	public function create($match_id)
	{
		$appointment = \App\Appointment::findRowByMatchIdAndGuestFuserId($match_id, Session::get('fuser_id'));
		if ($appointment) {
			abort(403, "既に申請済みです(一度キャンセルすると再度申請はできません)");
		}
		$match = \App\Match::find($match_id);
		$meet = \App\Meet::find($match->meet_id);
		$fuser = \App\User::findRowExistsById($meet->fuser_id);
		if ($match->fuser_id == Session::get('fuser_id')) {
			abort(403, '不正です。自分のイベントには参加できません');
		}
		$this->_data['match'] = $match;
		$this->_data['meet'] = $meet;
		$this->_data['fuser'] = $fuser;
		$this->_data['appointment'] = $appointment;
		return view('appointments.create', $this->_data);
	}
	// 申請リクエスト
	public function store(Request $request)
	{
		$appointment = \App\Appointment::findRowByMatchIdAndGuestFuserId($request->match_id, Session::get('fuser_id'));
		if ($appointment) {
			abort(403, "既に申請済みです(一度キャンセルすると再度申請はできません)");
		}
		$match = \App\Match::find($request->match_id);
		if (!$match) {
			abort(403, "matchが不正です");
		}
		if ($match->fuser_id == Session::get('fuser_id')) {
			abort(403, '不正です。自分のイベントには参加できません');
		}
		$this->validate($request, [
			'match_id' => 'required|numeric',
			'text' => 'required|max:255',
		]);
		try {
		DB::beginTransaction();
		$appointment = \App\Appointment::insertMatchIdMeetIdFuserIdGuestFuserIdGuestTextStatusId(
			$request->match_id,
			$match->meet_id,
			$match->fuser_id,
			Session::get('fuser_id'),
			$request->text,
			\App\Appointment::STATUS_ID_REQUEST
		);
		$message = \App\Message::insertFuserIdToFuserIdTextMeetIdMatchId(
			Session::get('fuser_id'),
			$match->fuser_id,
			$request->text,
			$match->meet_id,
			$request->match_id,
			\App\Appointment::STATUS_ID_REQUEST
		);
		// 申請件数更新
		$match->appointment_cnt = \App\Appointment::countRequestSuccessByMatchId($request->match_id);
		$match->save();
		$fuser = \App\User::findRowExistsById($match->fuser_id);
		$fuser->new_appointment_cnt += 1;
		$fuser->new_message_cnt += 1;
		$fuser->save();
		DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			return Redirect::back();
		}
		app('App\Services\EmailSend')
			->appointmentByFuserIdToFuserIdTextMeetIdMatchIdAppointmentIdStatusId(
				Session::get('fuser_id'),
				$match->fuser_id,
				$request->text,
				$match->meet_id,
				$request->match_id,
				$appointment->id,
				\App\Appointment::STATUS_ID_REQUEST
			);
		return redirect()->to($this->_apl_code_uri.'/appointment/'. $appointment->id);
	}
	public function show($id)
	{
		$appointment = \App\Appointment::find($id);
		switch (Session::get('fuser_id')) {
			case $appointment->fuser_id:
			case $appointment->guest_fuser_id:
				break;
			default:
				abort(403, "不正です");
		}
		$this->_data['appointment'] = $appointment;
		$this->_data['match'] = \App\Match::find($appointment->match_id);
		$this->_data['meet'] = \App\Meet::find($appointment->meet_id);
		$this->_data['guest_fuser'] = \App\User::findRowExistsById($appointment->guest_fuser_id);
		$this->_data['fuser'] = \App\User::findRowExistsById($appointment->fuser_id);
		return view('appointments.show', $this->_data);
	}
	// 申請結果
	public function edit($id)
	{
		$appointment = \App\Appointment::find($id);
		if ($appointment->fuser_id != Session::get('fuser_id')) {
			abort(403, "不正です");
		}
		$this->_data['appointment'] = $appointment;
		$this->_data['match'] = \App\Match::find($appointment->match_id);
		$this->_data['meet'] = \App\Meet::find($appointment->meet_id);
		$this->_data['guest_fuser'] = \App\User::findRowExistsById($appointment->guest_fuser_id);
		$this->_data['fuser'] = \App\User::findRowExistsById($appointment->fuser_id);
		return view('appointments.edit', $this->_data);
	}
	// 申請結果
	public function update(Request $request, $id)
	{
		$appointment = \App\Appointment::find($id);
		if ($appointment->fuser_id != Session::get('fuser_id')) {
			abort(403, "不正です");
		}
		$this->validate($request, [
			'status_id' => 'required|numeric|between:'
				.\App\Appointment::STATUS_ID_SUCCESS.','
				.\App\Appointment::STATUS_ID_NG,
			'text' => 'required|max:255',
		]);
		$match = \App\Match::find($appointment->match_id);
		$meet = \App\Match::find($appointment->meet_id);
		$guest_fuser = \App\User::findRowExistsById($appointment->guest_fuser_id);
		$appointment->status_id = $request->status_id;
		$appointment->text = $request->text;
		$appointment->save();
		if ($request->status_id) {
			if ($request->status_id == \App\Appointment::STATUS_ID_SUCCESS ||
				$request->status_id == \App\Appointment::STATUS_ID_NG) {
				$message = \App\Message::insertMatchIdMeetIdFuserIdToFuserIdTextAppointmentStatusId(
					$appointment->match_id,
					$appointment->meet_id,
					Session::get('fuser_id'),
					$appointment->guest_fuser_id,
					$request->text,
					$request->status_id
				);
				$fuser = \App\User::findRowExistsById($appointment->guest_fuser_id);
				if (!$fuser) {
					abort(403, "相手がいません");
				}
				$fuser->new_message_cnt += 1;
				$fuser->save();
			}
			// 成立
			if ($request->status_id == \App\Appointment::STATUS_ID_SUCCESS) {
				$match->guest_fuser_id = $appointment->guest_fuser_id;
				$match->appointment_cnt = \App\Appointment::countRequestSuccessByMatchId($appointment->match_id);
				$match->save();
			}
			// 否認
			if ($request->status_id == \App\Appointment::STATUS_ID_NG) {
				$match->appointment_cnt = \App\Appointment::countRequestSuccessByMatchId($appointment->match_id);
				$match->save();
			}
			// メール送信(成立・否認)
			if ($request->status_id == \App\Appointment::STATUS_ID_SUCCESS
				|| $request->status_id == \App\Appointment::STATUS_ID_NG) {
				app('App\Services\EmailSend')
					->appointmentResultByFuserIdToFuserIdTextMeetIdMatchIdAppointmentIdStatusId(
						Session::get('fuser_id'),
						$appointment->guest_fuser_id,
						$request->text,
						$appointment->meet_id,
						$appointment->match_id,
						$id,
						$request->status_id
					);
			}
		}
		return redirect()->to($this->_apl_code_uri.'/appointment');
	}
}
