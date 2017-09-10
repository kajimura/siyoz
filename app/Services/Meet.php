<?php
namespace App\Services;
use Carbon\Carbon;
class Meet
{
	public function getObjectsByRecords($meets)
	{
		$fusers = [];
		foreach ($meets as $key => $meet) {
			// 何度も取得しないように
			if (array_key_exists($meet->fuser_id, $fusers)) {
				$meet->fuser = $fusers[$meet->fuser_id];
			} else {
				$fuser = \App\User::findRowExistsById($meet->fuser_id);
				$fusers[$meet->fuser_id] = $fuser;
				$meet->fuser = $fuser;
			}
			$meet = $this->_getMatchsByRecord($meet);
		}
		return $meets;
	}
	public function getObjectByRecord($meet)
	{
		$meet = $this->_getMatchsByRecord($meet);
		$meet->fuser = \App\User::findRowExistsById($meet->fuser_id);
		return $meet;
	}
	private function _getMatchsByRecord($meet)
	{
		$current = Carbon::now();
		$matches = \App\Match::findAllByMeetId($meet->id);
		$fusers = [];
		if ($meet->day) {
			list ($year, $mon, $day) = explode("-", $meet->day);
			foreach ($matches as $match) {
				if ($match->end_time) {
					list ($hour, $min, $dummy) = explode(":", $match->start_time);
					$dt = Carbon::create($year, $mon, $day, $hour, $min);
					$match->msg_diff = $dt->diffForHumans($current); // 3 days before, 1 month after
					// guest_fuser取得 start
					if ($match->guest_fuser_id) {
						if (array_key_exists($match->guest_fuser_id, $fusers)) {
							$match->guest_fuser = $fusers[$match->guest_fuser_id];
						} else {
							$fuser = \App\User::findRowExistsById($match->guest_fuser_id);
							$fusers[$match->guest_fuser_id] = $fuser;
							$match->guest_fuser = $fuser;
						}
					}
					// guest_fuser取得 end
				}
			}
			$meet->matches = $matches;
		}
		return $meet;
	}
}
