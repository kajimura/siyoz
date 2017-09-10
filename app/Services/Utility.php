<?php
namespace App\Services;
use Carbon\Carbon;
class Utility
{
	// before after取得
	public static function getBeforeAfterByDay($day)
	{
		$current = Carbon::now();
		list ($year, $mon, $day) = explode("-", $day);
		$dt = Carbon::create($year, $mon, $day, "23", "45");
		return $dt->diffForHumans($current); // 3 days before, 1 month after
	}
}
