<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $guarded = array('id');
	public static function findRowById($id)
	{
		return self::where('id', $id)->first();
	}
	public static function findAllByFuserIdOrToFuserId($fuser_id, $to_fuser_id)
	{
		return self::where('fuser_id', $fuser_id)
				->orWhere('to_fuser_id', $to_fuser_id)
				->orderBy('created_at', 'DESC')
				->get();
	}
	public static function findAllByMatchIdAndFuserIdOrToFuserId($match_id, $fuser_id, $to_fuser_id)
	{
		return self::where('match_id', $match_id)
				->whereRaw('(fuser_id = ? OR to_fuser_id = ?)', [$fuser_id, $to_fuser_id])
				//->whereRaw('fuser_id = ?', [$to_fuser_id])
				->orderBy('created_at', 'DESC')
				->get();
	}
	// 通常メッセージ
	public static function insertFuserIdToFuserIdTextMeetIdMatchId(
		$fuser_id, $to_fuser_id, $text, $meet_id, $match_id)
	{
		$class = get_class();
		return $class::create([
			'apl_id' => app('App\Services\Apl')->getId(),
			'fuser_id' => $fuser_id,
			'to_fuser_id' => $to_fuser_id,
			'text' => $text,
			'meet_id' => $meet_id,
			'match_id' => $match_id,
		]);
	}
	// 申請時のメッセージ
	public static function insertMatchIdMeetIdFuserIdToFuserIdTextAppointmentStatusId(
		$match_id, $meet_id, $fuser_id, $to_fuser_id, $text, $status_id)
	{
		$class = get_class();
		return $class::create([
			'apl_id' => app('App\Services\Apl')->getId(),
			'match_id' => $match_id,
			'meet_id' => $meet_id,
			'fuser_id' => $fuser_id,
			'to_fuser_id' => $to_fuser_id,
			'text' => $text,
			'appointment_status_id' => $status_id,
			]);
	}
}
