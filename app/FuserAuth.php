<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuserAuth extends Model
{
	protected $guarded = array('id');
	public static function findRowById($id)
	{
		return self::where('id', $id)->first();
	}
	public static function findRowByFid($id)
	{
		return self::where('fid', $id)->first();
	}
	public static function updateUserId(
		$fuser,
		$user_id
	) {
		$fuser->user_id = $user_id;
		$fuser->save();
	}
	public static function insertFidEmailNameNicknameTokenRefreshTokenExpiresInAvatarAvatarOriginalGenderVerified(
		$fid, $email, $name, $nickname, $token, $refreshToken, $expiresIn, $avatar, $avatar_original, $gender, $verified
		) {
		$class = get_class();
		$fuser = $class::create([
			'fid' => $fid,
			'email' => $email,
			'name' => $name,
			'nickname' => $nickname,
			'token' => $token,
			'refresh_token' => $refreshToken,
			'expires_in' => $expiresIn,
			'avatar' => $avatar,
			'avatar_original' => $avatar_original,
			'gender' => $gender,
			'verified' => $verified,
			'updated_at_token' => date('Y-m-d H:i:s'),
		]);
	}
	public static function updateFidEmailNameNicknameTokenRefreshTokenExpiresInAvatarAvatarOriginalGenderVerified(
		$fuser,
		$fid, $email, $name, $nickname, $token, $refreshToken, $expiresIn, $avatar, $avatar_original, $gender, $verified
		) {
		$fuser->fid = $fid;
		$fuser->email = $email;
		$fuser->name = $name;
		$fuser->nickname = $nickname;
		$fuser->token = $token;
		$fuser->refresh_token = $refreshToken;
		$fuser->expires_in = $expiresIn;
		$fuser->avatar = $avatar;
		$fuser->avatar_original = $avatar_original;
		$fuser->gender = $gender;
		$fuser->verified = $verified;
		$fuser->updated_at_token = date('Y-m-d H:i:s');
		$fuser->save();
	}
}
