<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Laravel\Socialite\Contracts\Factory as Socialite;
use DB;
class FacebookController extends Controller
{
	protected $socialite;

	public function __construct(Socialite $socialite)
	{
		$this->socialite = $socialite;
		$this->_checkApl();
	}
	public function facebookLogin(Request $request)
	{
		if (preg_match("/-test/", $request->url())) {
			if ($request->user_id) {
				$user = \App\User::find($request->user_id);
			} else {
				// $user = \App\User::find(1);
				$user = \App\User::findRowByEmail("masahiko.kajimura@gmail.com");
				if (!$user) {
					\App\User::insertEmailNameNicknameAvatarAvatarOriginalGenderVerified(
						"masahiko.kajimura@gmail.com", "masa", "masa",
						"/assets/img/sample_prof/fusigibana.jpg", "/assets/img/sample_prof/fusigibana.jpg",
						"male", 1
					);
				}
			}
			if ($user) {
				//Session::put('fid', $user->fid);
				Session::put('fuser_id', $user->id);
				Session::put('name', $user->name);
			}
			if (preg_match("!/apl!", $this->_apl_code_uri)) {
				return \Redirect::to("/apl/apls");
			} else {
				return \Redirect::to($this->_apl_code_uri.'/meet');
			}
		} else {
			return $this->socialite->driver('facebook')->redirect();
		}
	}
	public function facebookCallback(Request $request)
	{
		// echo Session::get('fid');
		// error=access_denied&error_code=200&error_description=Permissions+error&error_reason=user_denied&
		if ($request->get('error') == "access_denied") {
			abort(403, "またの登録お待ちしてます");
		}
		try {
			$facebook = $this->socialite->driver('facebook')->user();
			DB::beginTransaction();
			$fuser = \App\FuserAuth::findRowByFid($facebook->id);
			if (!$fuser) {
				\App\FuserAuth::insertFidEmailNameNicknameTokenRefreshTokenExpiresInAvatarAvatarOriginalGenderVerified(
					$facebook->id, $facebook->email, $facebook->name, $facebook->nickname, $facebook->token,
					$facebook->refreshToken, $facebook->expiresIn, $facebook->avatar, $facebook->avatar_original,
					$facebook->user['gender'], $facebook->user['verified']
				);
			} else {
				\App\FuserAuth::updateFidEmailNameNicknameTokenRefreshTokenExpiresInAvatarAvatarOriginalGenderVerified(
					$fuser,
					$facebook->id, $facebook->email, $facebook->name, $facebook->nickname, $facebook->token,
					$facebook->refreshToken, $facebook->expiresIn, $facebook->avatar, $facebook->avatar_original,
					$facebook->user['gender'], $facebook->user['verified']
				);
			}
			$insert_flag = false;
			$user = \App\User::findRowByEmail($facebook->email);
			if (!$user) {
				$insert_flag = true;;
				\App\User::insertEmailNameNicknameAvatarAvatarOriginalGenderVerified(
					$facebook->email, $facebook->name, $facebook->nickname,
					$facebook->avatar, $facebook->avatar_original,
					$facebook->user['gender'], $facebook->user['verified']
				);
				$user = \App\User::findRowByEmail($facebook->email);
			}
			DB::commit();
			Session::regenerate();
			// Session::put('fid', $user->fid);
			Session::put('fuser_id', $user->id);

			Session::put('name', $user->name);
			// return \Redirect::to($this->_apl_code_uri.'/help/wait');
			if ($insert_flag) {
				return \Redirect::to($this->_apl_code_uri.'/prof/create');
			}
			return \Redirect::to($this->_apl_code_uri.'/prof/home');
		} catch (ClientException $e) {
			abort(403, "システム不具合により認証に失敗しました");
		}
	}
}

