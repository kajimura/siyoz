<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use DB;
use Carbon\Carbon;
class MeetController extends Controller
{
	public function __construct()
	{
		$this->_data['self_fuser_id'] = Session::get('fuser_id');
		$this->_checkUse();
		$this->_controllerName = "イベント";
		$this->_checkApl();
	}
	public function index()
	{
		$this->_actionName = "一覧";
		$meets = \App\Meet::findAllByAplId($this->_apl->id);
		$meets = app('App\Services\Meet')->getObjectsByRecords($meets);
		$this->_data['meets'] = $meets;
		$this->postDispatchTitle();
		return view('meets.index', $this->_data);
	}
	public function create()
	{
		$fuser_id = Session::get('fuser_id');
		if (!$fuser_id) {
			abort(403, '不正です meet/store');
		}
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, 'ユーザーが存在しません');
		}
		$this->_checkAplSessionUser();
		$dt = Carbon::now();
		$dt->year   = date('Y');
		$dt->month  = date('m');
		$dt->day	= date('d');
		$dt->hour   = date('H');
		$dt->addHour();
		$this->_data['day'] = sprintf("%04d-%02d-%02d", $dt->year, $dt->month, $dt->day);
		$this->_data['hour'] = $dt->hour;
		$this->_data['min']	 = (int)(date('i') / 15) * 15;
		return view('meets.create', $this->_data);
	}
	public function store(Request $request)
	{
		$fuser_id = Session::get('fuser_id');
		if (!$fuser_id) {
			abort(403, '不正です meet/store');
		}
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, 'ユーザーが存在しません');
		}
		$this->validate($request, [
			'day' => 'required|date_format:"Y-m-d"',
			'hour' => 'required|numeric|min:0|max:23',
			'min' => 'required|numeric|min:0|max:59',
			'onemin' => 'required|numeric|min:1|max:500',
			'time' => 'required|numeric|min:1|max:10',
			'location_name' => 'required|max:255',
			'location_address' => 'required|max:255',
			'text' => 'required|max:255',
		]);
		$gmap = app('Kz_GoogleMapModel');
		$ret = $gmap->getHttpLatLngByAddress($request->location_address);
		DB::beginTransaction();
		$matches = app('App\Services\Match')->getMatchsByDayHourMinOneminTime(
					$request->day,
					$request->hour,
					$request->min,
					$request->onemin,
					$request->time);
		$meet = \App\Meet::insertFuserIdLocationNameLocationAddressDayTextLatLng(
			$fuser_id,
			$request->location_name,
			$request->location_address,
			$request->day,
			$request->text,
			$ret['lat'],
			$ret['lng']
		);
		if ($meet->id) {
			foreach ($matches as $_match) {
				$match = \App\Match::insertFuserIdMeetIdStartTimeEndTime(
					$fuser_id,
					$meet->id,
					$_match['start_time'],
					$_match['end_time']
				);
			}
		}
		DB::commit();
		return redirect()->to($this->_apl_code_uri.'/meet');
	}
	public function show($id)
	{
		$meet = \App\Meet::find($id);
		$matches = \App\Match::findAllByFuserIdAndMeetId($meet->fuser_id, $id);
		$fuser = \App\User::findRowExistsById($meet->fuser_id);
		$this->_checkAplUser($fuser);
		$this->_actionName = 
				sprintf("%s %s %s %s %s",
				$meet->text,
				$meet->location_name,
				$meet->location_address,
				$meet->day,
				$fuser->name
			);
		$meets = [];
		foreach ($matches as $match) {
			// 何度も取得しないように
			if (array_key_exists($match->meet_id, $meets)) {
				$match->meet = $meets[$match->meet_id];
			} else {
				$meet = \App\Meet::find($match->meet_id);
				$meets[$match->meet_id] = $meet;
				$match->meet = $meet;
			}
		}
		$meet = app('App\Services\Meet')->getObjectByRecord($meet);
		$this->_data['before_after'] = \App\Services\Utility::getBeforeAfterByDay($meet->day);
		$this->_data['matches'] = $matches;
		$this->_data['meet'] = $meet;
		$this->_data['fuser'] = $fuser;
		$this->postDispatchTitle();
		return view('meets.show', $this->_data);
	}
	public function edit($id)
	{
		$meet = \App\Meet::find($id);
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, "あなたは会員ではありません");
		}
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser || $fuser->id != $meet->fuser_id) {
			abort(403, '不正です');
		}
		$this->_data['meet'] = $meet;
		return view('meets.edit', $this->_data);
	}
	public function update(Request $request, $id)
	{
		$meet = \App\Meet::find($id);
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, "あなたは会員ではありません");
		}
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser || $fuser->id != $meet->fuser_id) {
			abort(403, '不正です');
		}
		$this->validate($request, [
			'day' => 'required|date_format:"Y-m-d"',
			'location_name' => 'required|max:255',
			'location_address' => 'required|max:255',
			'text' => 'required|max:255',
		]);
		$meet->location_name = $request->location_name;
		$meet->location_address = $request->location_address;
		$meet->day = $request->day;
		$meet->text = $request->text;
		$meet->save();
		return redirect()->to($this->_apl_code_uri.'/meet');
	}
	public function destroy($id)
	{
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, "あなたは会員ではありません");
		}
		DB::beginTransaction();
		$meet = \App\Meet::find($id);
		$matches = \App\Match::findAllByMeetId($meet->id);
		foreach ($matches as $match) {
			if ($match->appointment_cnt > 0) {
				abort(403, '申請者がいるため削除できません');
			}
		}
		foreach ($matches as $match) {
			$match->delete();
		}
		$meet->delete();
		DB::commit();
		return redirect()->to($this->_apl_code_uri.'/meet');
	}
}
