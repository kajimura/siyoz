<?php

namespace App\Services;

use Carbon\Carbon;

class Match
{
	// マッチ登録で開始終了リスト取得
	public function getMatchsByDayHourMinOneminTime($day, $hour, $min, $onemin, $time)
	{
		$matches = [];
		$dt = Carbon::now();
		$dt->year = substr($day, 0, 4);
		$dt->month  = substr($day, 5, 2);
		$dt->day    = substr($day, 8, 2);
		$dt->hour   = $hour;
		$dt->minute = $min;
		$dt->second = 0;
		for ($t = 1; $t <= $time; $t++) {
			$matches[] = [
				'start_time' => $dt->toTimeString(),
				'end_time' => self::_getEndtimeByStarttime($dt, $onemin)
			];
		}
		return $matches;
	}
	// マッチ登録で開始終了単体取得
	public function getMatchByHourMinOnemin($hour, $min, $onemin)
	{
		$matches = [];
		$dt = Carbon::now();
		$dt->hour   = $hour;
		$dt->minute = $min;
		$dt->second = 0;
		return [
				'start_time' => $dt->toTimeString(),
				'end_time' => self::_getEndtimeByStarttime($dt, $onemin)
				];
	}
	private function _getEndtimeByStarttime($dt, $onemin)
	{
		$dt->addMinutes($onemin);
		return $dt->toTimeString();
	}
}
