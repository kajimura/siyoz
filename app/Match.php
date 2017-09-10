<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
	protected $guarded = array('id');
	public static function findRowById($id)
	{
		return self::where('id', $id)->first();
	}
	public static function findRowByFuserId($id)
	{
		return self::where('fuser_id', $id)->first();
	}
	public static function findOneEndTimeByMeetId($meet_id)
	{
		return self::where('meet_id', $meet_id)
				->orderBy('end_time', 'DESC')
				->first()->end_time;
	}
	public static function findAll()
	{
		return self::orderBy('start_time')->get();
	}
	public static function findAllByAplId($apl_id)
	{
		return self::where('apl_id', $apl_id)
				->orderBy('start_time')
				->get();
	}
	public static function findAllByMeetId($id)
	{
		return self::where('meet_id', $id)->orderBy('start_time')->get();
	}
	public static function findAllByFuserIdAndMeetId($fuser_id, $meet_id)
	{
		return self::where('fuser_id', $fuser_id)
				->where('meet_id', $meet_id)
				->orderBy('start_time')
				->get();
	}
	public static function insertFuserIdMeetIdStartTimeEndTime(
		$fuser_id, $meet_id, $start_time, $end_time)
	{
		$class = get_class();
		return $class::create([
			'apl_id' => app('App\Services\Apl')->getId(),
			'fuser_id' => $fuser_id,
			'meet_id' => $meet_id,
			'start_time' => $start_time,
			'end_time' => $end_time,
		]);
	}
}
