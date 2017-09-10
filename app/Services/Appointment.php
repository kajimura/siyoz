<?php
namespace App\Services;
class Appointment
{
	public function getObjectsByRecords($appointments)
	{
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
			if (array_key_exists($appointment->fuser_id, $fusers)) {
				$appointment->fuser = $fusers[$appointment->fuser_id];
			} else {
				$fuser = \App\User::findRowExistsById($appointment->fuser_id);
				$fusers[$appointment->fuser_id] = $fuser;
				$appointment->fuser = $fuser;
			}
		}
		return $appointments;
	}
}
