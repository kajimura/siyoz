<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use DB;
use Carbon\Carbon;
class MatchController extends Controller
{
	public function __construct()
	{
		$this->_checkUse();
		$this->_data['self_fuser_id'] = Session::get('fuser_id');
		$this->_checkApl();
	}
	public function create($meet_id)
	{
		$fuser_id = Session::get('fuser_id');
		if (!$fuser_id) {
			abort(403, '不正です match/create');
		}
		$meet = \App\Meet::find($meet_id);
		if (!$meet) {
			abort(403, '不正です match/create');
		}
		if ($meet->fuser_id != Session::get('fuser_id')) {
			abort(403, '不正です match/create');
		}
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, "あなたは会員ではありません");
		}
		$end_time = \App\Match::findOneEndTimeByMeetId($meet_id);
		list($this->_data['hour'], $this->_data['min'], $dummy) = explode(':', $end_time);
		$this->_data['meet'] = $meet;
		return view('matches.create', $this->_data);
	}
	public function store(Request $request)
	{
		$fuser_id = Session::get('fuser_id');
		if (!$fuser_id) {
			abort(403, '不正です match/store');
		}
		$meet = \App\Meet::find($request->meet_id);
		if (!$meet) {
			abort(403, '不正です match/store');
		}
		if ($meet->fuser_id != Session::get('fuser_id')) {
			abort(403, '不正です match/store');
		}
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, "あなたは会員ではありません");
		}
		$this->validate($request, [
			'hour' => 'required|min:2|max:2',
			'min' => 'required|min:2|max:2',
			'onemin' => 'required|min:1|max:3'
				]);
		$_match = app('App\Services\Match')->getMatchByHourMinOnemin(
					$request->hour,
					$request->min,
					$request->onemin);
		DB::beginTransaction();
		$match = \App\Match::insertFuserIdMeetIdStartTimeEndTime(
			$fuser_id,
			$request->meet_id,
			$request->hour.":".$request->min.":00",
			$_match['end_time']
		);
		DB::commit();
		return redirect()->to($this->_apl_code_uri.'/meet/'.$request->meet_id);
	}
	public function show($id)
	{
		$match = \App\Match::find($id);
		$meet = \App\Meet::find($match->meet_id);
		$fuser = \App\User::findRowExistsById($meet->fuser_id);
		$this->_checkAplUser($fuser);
		$this->_data['match'] = $match;
		$this->_data['meet'] = $meet;
		$this->_data['fuser'] = $fuser;
		$this->_actionName = 
			sprintf("%s~%s %s %s %s %s %s",
				substr($match->start_time, 0, 5),
				substr($match->end_time, 0, 5),
				$meet->text,
				$meet->day,
				$meet->location_name,
				$meet->location_address,
				$fuser->name
			);
		$current = Carbon::now();
		list($year, $mon, $day) = explode('-', $meet->day);
		list($hour, $min, $dummy) = explode(':', $match->start_time);
		$dt = Carbon::create($year, $mon, $day, $hour, $min);
		$this->_data['day_diff'] = $dt->diffForHumans($current); // 3 days before, 1 month after
		if (Session::get('fuser_id') != $match->fuser_id) {
			// 他人が主催のページ
			// 自分が申請してるか
			$this->_data['self_appointment'] = \App\Appointment::findRowByMatchIdAndGuestFuserId($id, Session::get('fuser_id'));
		} else {
			// 自分が主催のページ
			$appointments = \App\Appointment::findAllByMatchId($id);
			$fusers = [];
			$meets = [];
			$matches = [];
			foreach ($appointments as $appointment) {
				// 何度も取得しないように
				if (array_key_exists($appointment->match_id, $matches)) {
					$appointment->match = $matches[$appointment->match_id];
				} else {
					$match = \App\Match::find($appointment->match_id);
					$matches[$appointment->match_id] = $match;
					$appointment->match = $match;
				}
				if (array_key_exists($appointment->meet_id, $meets)) {
					$appointment->meet = $meets[$appointment->meet_id];
				} else {
					$meet = \App\Meet::find($appointment->meet_id);
					$meets[$appointment->meet_id] = $meet;
					$appointment->meet = $meet;
				}
				if (array_key_exists($appointment->guest_fuser_id, $fusers)) {
					$appointment->guest_fuser = $fusers[$appointment->guest_fuser_id];
				} else {
					$fuser = \App\User::findRowExistsById($appointment->guest_fuser_id);
					$fusers[$appointment->guest_fuser_id] = $fuser;
					$appointment->guest_fuser = $fuser;
				}
			}
			$this->_data['appointments'] = $appointments;
		}
		if ($match->guest_fuser_id) {
			$guest_fuser = \App\User::findRowExistsById($match->guest_fuser_id);
			$this->_data['guest_fuser'] = $guest_fuser;
		}
		$this->postDispatchTitle();
		return view('matches.show', $this->_data);
	}
	public function destroy($id)
	{
		$fuser_id = Session::get('fuser_id');
		if (!$fuser_id) {
			abort(403, '不正です match/destroy 1');
		}
		$match = \App\Match::find($id);
		$meet = \App\Meet::find($match->meet_id);
		if (!$meet) {
			abort(403, '不正です match/destroy 2');
		}
		if ($meet->fuser_id != Session::get('fuser_id')) {
			abort(403, '不正です match/destroy 3');
		}
		$appointments = \App\Appointment::findRowByMatchId($match->id);
		if (count($appointments)) {
			abort(403, '一度申請されているため削除できません');
		}
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, "あなたは会員ではありません");
		}
		$match->delete();
		return redirect()->to($this->_apl_code_uri.'/meet/'.$match->meet_id);
	}
}
