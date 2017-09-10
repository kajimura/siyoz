<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Input;
class ProfController extends Controller
{
	private $_fid = "";
	public function __construct()
	{
		$this->_checkUse();
		$this->_checkApl();
		$fuser_id = Session::get('fuser_id');
		if ($fuser_id) {
			$fuser = \App\User::findRowExistsById($fuser_id);
			if ($fuser) {
				$this->_data['self_fuser'] = $fuser;
			}
		}
	}
	public function home()
	{
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, 'ユーザーが存在しません');
		}
		return redirect()->to($this->_apl_code_uri.'/prof/'. $fuser->id);
	}
	public function index()
	{
		// $fusers = \App\User::findAllExists();
		$fusers = \App\User::findAllExistsByAplId($this->_apl->id);
		$this->_data['fusers'] = $fusers;
		return view('profs.index', $this->_data);
	}
	public function create()
	{
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, '不正です');
		} else {
			$this->_data['fuser'] = $fuser;
		}
		$this->_data['facebook_code'] = "";
		if (preg_match("!/([\d]{10,})/!", $fuser->avatar, $matches)) {
			$this->_data['facebook_code'] = $matches[1];
		}
		return view('profs.create', $this->_data);
	}
	public function store(Request $request)
	{
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser) {
			abort(403, '不正です');
		} else {
			$this->_data['fuser'] = $fuser;
		}
		$this->validate($request, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'facebook_code' => 'max:63',
		]);
		if ($fuser) {
			$fuser->name = $request->name;
			$fuser->email = $request->email;
			$fuser->facebook_code = $request->facebook_code;
			$fuser->save();
		}
		Session::put('name', $request->name);
		// return redirect()->to($this->_apl_code_uri.'/prof/'. $fuser->id);
		$this->_data['fuser'] = $fuser;
		app('App\Services\EmailSend')
			->registByFuserId($fuser->id);
		return view('profs.store', $this->_data);
	}
	public function show($id)
	{
		$fuser = \App\User::findRowExistsById($id);
		if (!$fuser) {
			abort(403, 'ユーザーが存在しません');
		} else {
			$this->_data['fuser'] = $fuser;
		}
		$this->_checkAplUser($fuser);
		$this->_actionName = sprintf(
					"%s %s %s",
					$fuser->name,
					$fuser->text,
					$fuser->location
				);
		$this->postDispatchTitle();
		return view('profs.show', $this->_data);
	}
	public function edit($id)
	{
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser || $fuser->id != $id) {
			abort(403, '不正です');
		} else {
			$this->_data['fuser'] = $fuser;
		}
		return view('profs.edit', $this->_data);
	}
	public function update(Request $request, $id)
	{
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser || $fuser->id != $id) {
			abort(403, '不正です');
		} else {
			$this->_data['fuser'] = $fuser;
		}
		$this->validate($request, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'text' => 'max:255',
			'location' => 'max:31',
			'facebook_code' => 'max:63',
			'twitter_code' => 'max:63',
			'blog_url' => 'max:255',
			'tag' => 'max:255',
		]);
		if ($fuser) {
			$fuser->name = $request->name;
			$fuser->email = $request->email;
			$fuser->text = $request->text;
			$fuser->location = $request->location;
			$fuser->facebook_code = $request->facebook_code;
			$fuser->twitter_code = $request->twitter_code;
			$fuser->blog_url = $request->blog_url;
			$fuser->tag = $request->tag;
			// $fuser->avatar = $request->avatar;
			$fuser->save();
		}
		Session::put('name', $request->name);
		return redirect()->to($this->_apl_code_uri.'/prof/'. $fuser->id);
	}
	public function destroy($id)
	{
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$fuser || $fuser->id != $id) {
			abort(403, 'ユーザーが存在しません');
		}
		$fuser->del_flag = 1;
		$fuser->save();
		return redirect()->to($this->_apl_code_uri.'/flogout');
	}
}
