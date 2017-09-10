<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
	const STATUS_ID_DEFAULT = 0; // 初期値
	const STATUS_ID_REQUEST = 1; // ゲストがリクエスト送信
	const STATUS_ID_SUCCESS = 2; // 主催者がリクエスト承認
	const STATUS_ID_NG = 3; // 主催者がリクエスト否認
	const STATUS_ID_CANCEL= 4; // ゲストがリクエストキャンセル
	protected $guarded = array('id');
	public static function getStatusNameByStatusId($status_id)
	{
		switch ($status_id) {
		case self::STATUS_ID_REQUEST:
			return '申請';
		case self::STATUS_ID_SUCCESS:
			return '承認';
		case self::STATUS_ID_NG:
			return '否認';
		case self::STATUS_ID_CANCEL:
			return '申請キャンセル';
		}
	}
	public static function findRowById($id)
	{
		return self::where('id', $id)->first();
	}
	public static function findRowByFuserId($id)
	{
		return self::where('fuser_id', $id)->first();
	}
	public static function findRowByMatchId($match_id)
	{
		return self::where('match_id', $match_id)
				->orderBy('id')
				->get();
	}
	public static function findAllByFuserIdAndMeetId($fuser_id, $meet_id)
	{
		return self::where('fuser_id', $fuser_id)
				->where('meet_id', $meet_id)
				->orderBy('start_time')
				->get();
	}
	public static function findRowByMatchIdAndGuestFuserId($match_id, $guest_fuser_id)
	{
		return self::where('match_id', $match_id)
				->where('guest_fuser_id', $guest_fuser_id)
				->first();
	}
	public static function findAllStatusIdRequestByFuserId($fuser_id)
	{
		return self::where('fuser_id', $fuser_id)
				->where('status_id', self::STATUS_ID_REQUEST)
				->orderBy('id', 'DESC')
				->get();
	}
	public static function findAllStatusIdRequestByGuestFuserId($fuser_id)
	{
		return self::where('guest_fuser_id', $fuser_id)
				->where('status_id', self::STATUS_ID_REQUEST)
				->orderBy('id', 'DESC')
				->get();
	}
	public static function findAllByFuserId($fuser_id)
	{
		return self::where('fuser_id', $fuser_id)
				->orderBy('id', 'DESC')
				->get();
	}
	public static function findAllByGuestFuserId($fuser_id)
	{
		return self::where('guest_fuser_id', $fuser_id)
				->orderBy('id', 'DESC')
				->get();
	}
	public static function findAllByMatchId($id)
	{
		return self::where('match_id', $id)
				->orderBy('id', 'DESC')
				->get();
	}
	public static function countByMatchId($match_id)
	{
		return self::where('match_id', $match_id)->count();
	}
	// リクエスト&成立件数
	public static function countRequestSuccessByMatchId($match_id)
	{
		return self::where('match_id', $match_id)
					->whereIn('status_id', [self::STATUS_ID_REQUEST, self::STATUS_ID_SUCCESS])
					->count();
	}
	public static function countByMatchIdAndGuestFuserId($match_id, $guest_fuser_id)
	{
		return self::where('match_id', $match_id)
						->where('guest_fuser_id', $guest_fuser_id)
						->count();
	}
	/**
	 * マッチデータ挿入
	 * ex
	 * print_r(
	 * [
	 * 			'apl_id' => app('App\Services\Apl')->getId(),
	 * 			'match_id' => $match_id,
	 * 			'meet_id' => $meet_id,
	 * 			'fuser_id' => $fuser_id,
	 * 			'guest_fuser_id' => $to_fuser_id,
	 * 			'guest_text' => $text,
	 * 			'status_id' => $status_id,
	 * 		]
	 * ,1);
	 * [apl_id] => 1
	 * [match_id] => 180
	 * [meet_id] => 48
	 * [fuser_id] => 1
	 * [guest_fuser_id] => 3
	 * [guest_text] => おねがいします。
	 * [status_id] => 1
	 */
	public static function insertMatchIdMeetIdFuserIdGuestFuserIdGuestTextStatusId(
			$match_id, $meet_id, $fuser_id, $to_fuser_id, $text, $status_id)
	{
		$class = get_class();
		return $class::create([
			'apl_id' => app('App\Services\Apl')->getId(),
			'fuser_id' => $fuser_id,
			'match_id' => $match_id,
			'meet_id' => $meet_id,
			'guest_fuser_id' => $to_fuser_id,
			'guest_text' => $text,
			'status_id' => $status_id,
		]);
	}
}
