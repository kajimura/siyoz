<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	const FUSER_ID_SYSTEM = 0;
	protected $guarded = array('id');
	public static function findRowById($id)
	{
		return self::where('id', $id)->first();
	}
	public static function findRowByCode($code)
	{
		return self::where('code', $code)->first();
	}
	public static function findRowByEmail($email)
	{
		return self::where('email', $email)
				->where('apl_id', app('App\Services\Apl')->getId())
				->first();
	}
	public static function findAll()
	{
		return self::orderBy('updated_at', 'DESC')->get();
	}
	public static function findRowExistsById($id)
	{
		return self::where('id', $id)
				->where('del_flag', 0)
				->first();
	}
	public static function findRowExistsByCode($code)
	{
		return self::where('code', $code)
				->where('del_flag', 0)
				->first();
	}
	public static function findAllExists()
	{
		return self::where('del_flag', 0)
				->orderBy('updated_at', 'DESC')
				->get();
	}
	public static function findAllExistsByAplId($apl_id)
	{
		return self::where('del_flag', 0)
				->where('apl_id', $apl_id)
				->orderBy('updated_at', 'DESC')
				->get();
	}
	public static function insertEmailNameNicknameAvatarAvatarOriginalGenderVerified(
		$email, $name, $nickname,
		$avatar, $avatar_original, $gender, $verified
		) {
		$class = get_class();
		$fuser = $class::create([
			'apl_id' => app('App\Services\Apl')->getId(),
			'email' => $email,
			'name' => $name,
			'nickname' => $nickname,
			'avatar' => $avatar,
			'avatar_original' => $avatar_original,
			'gender' => $gender,
			'verified' => $verified,
		]);
		self::registRandomCodeById($fuser, $fuser->id);
	}
	public static function updateAvatarAvatarOriginalGenderVerified(
		$fuser,
		// $token, $refreshToken, $expiresIn, $avatar, $avatar_original, $gender, $verified
		$avatar, $avatar_original, $gender, $verified
			) {
		$fuser->avatar = $avatar;
		$fuser->avatar_original = $avatar_original;
		$fuser->gender = $gender;
		$fuser->verified = $verified;
		$fuser->del_flag = 0; // 削除フラグを0へ
		$fuser->save();
	}
	public static function registRandomCodeById($fuser, $id)
	{
		$fuser->code = substr(md5(time(). $id), 0, 12);
		$fuser->save();
	}
}
