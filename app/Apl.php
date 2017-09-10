<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apl extends Model
{
	protected $guarded = array('id');
	public static function findRowByDomain($domain)
	{
		return self::where('domain', $domain)->first();
	}
	public static function findRowByCode($code)
	{
		return self::where('code', $code)->first();
	}
	public static function findRowById($id)
	{
		return self::where('id', $id)->first();
	}
	public static function findAllExistsByUserId($user_id)
	{
		return self::where('user_id', $user_id)
				->where('del_flag', 0)
				->orderBy('id')->get();
	}
	public static function insertNameCodeUserId($name, $code, $user_id)
	{
		$class = get_class();
		return $class::create([
			'name' => $name,
			'code' => $code,
			'user_id' => $user_id,
			'domain' => $code.".siyoz.net",
			'title' => $name,
			'description' => $name,
			'keywords' => $name,
		]);
	}
}
