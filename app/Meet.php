<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meet extends Model
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
	public static function findAll()
	{
		return self::orderBy('id', 'DESC')->get();
	}
	public static function findAllByAplId($apl_id, $limit = 1000)
	{
		return self::where('apl_id', $apl_id)
					->orderBy('id', 'DESC')
					->take($limit)
					->get();
	}
	public static function findAllLimit($limit)
	{
		return self::orderBy('id', 'DESC')
				->take($limit)
				->get();
	}
	public static function findAllSample($limit)
	{
		return self::whereIn('fuser_id', [1, 2, 3, 4, 5, 6, 8, 9, 10])
				->orderBy('id', 'DESC')
				->take($limit)
				->get();
	}
	public static function insertFuserIdLocationNameLocationAddressDayTextLatLng(
		$fuser_id, $location_name, $location_address, $day,
		$text, $lat, $lng)
	{
		$class = get_class();
		return $class::create([
			'apl_id' => $apl = app('App\Services\Apl')->getId(),
			'fuser_id' => $fuser_id,
			'location_name' => $location_name,
			'location_address' => $location_address,
			'day' => $day,
			'text' => $text,
			'lat' => $lat,
			'lng' => $lng,
		]);
	}
}
