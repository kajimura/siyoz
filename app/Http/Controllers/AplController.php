<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class AplController extends Controller
{
	private $_fid = "";
	public function __construct()
	{
		$this->_data['apl_name'] = "待ち合わせWeb作成サービス | マチアワ";
		$this->_data['apl_code_uri'] = "/apl";
	}
	// sessionがない時はfacebook/loginへ移動
	private function _checkRedirectAplUser()
	{
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		$apl = \App\Apl::findRowByCode('apl');
		if (!$user || $user->id != $apl->user_id) {
			return true;
		}
		return false;
	}
	public function index()
	{
		return view('apls.index', $this->_data);
	}
	public function apls()
	{
		if ($this->_checkRedirectAplUser()) {
			return redirect()->to('/apl/facebook');
		}
		$apls = \App\Apl::findAllExistsByUserId(Session::get('fuser_id'));
		$this->_data['apls'] = $apls;
		//$this->postDispatchTitle();
		return view('apls.apls', $this->_data);
	}
	public function create()
	{
		if ($this->_checkRedirectAplUser()) {
			return redirect()->to('/apl/facebook');
		}
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$user) {
			abort(403, '不正です');
		} else {
			$this->_data['user'] = $user;
		}
		$this->_data['apl'] = app('App\User');
		return view('apls.create', $this->_data);
	}
	public function store(Request $request)
	{
		if ($this->_checkRedirectAplUser()) {
			return redirect()->to('/apl/facebook');
		}
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$user) {
			abort(403, '不正です');
		} else {
			$this->_data['user'] = $user;
		}
		$this->validate($request, [
			'name' => 'required|max:63',
			'code' => 'required|min:4|max:15',
		]);
		$apl = \App\Apl::findRowByCode($request->code);
		if ($apl) {
			abort(500, 'そのidは既に使用されています');
		}
		\App\Apl::insertNameCodeUserId($request->name, $request->code, $user->id);
		$this->_data['user'] = $user;
		return view('apls.store', $this->_data);
	}
	public function show($id)
	{
		if ($this->_checkRedirectAplUser()) {
			return redirect()->to('/apl/facebook');
		}
	}
	public function edit($id)
	{
		if ($this->_checkRedirectAplUser()) {
			return redirect()->to('/apl/facebook');
		}
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		$apl = \App\Apl::findRowById($id);
		if (!$user || $user->id != $apl->user_id) {
			abort(403, '不正です');
		} else {
			$this->_data['user'] = $user;
			$this->_data['apl'] = $apl;
		}
		return view('apls.edit', $this->_data);
	}
	public function update(Request $request, $id)
	{
		if ($this->_checkRedirectAplUser()) {
			return redirect()->to('/apl/facebook');
		}
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		$apl = \App\Apl::findRowById($id);
		if (!$user || $user->id != $apl->user_id) {
			abort(403, '不正です');
		} else {
			$this->_data['user'] = $user;
			$this->_data['apl'] = $apl;
		}
		$this->validate($request, [
			'name' => 'required|max:63',
			'description' => 'max:255',
			'title' => 'max:31',
		]);
		if ($apl) {
			$apl->name = $request->name;
			$apl->description = $request->description;
			$apl->title = $request->title;
			$apl->save();
		}
		return redirect()->to('/apl/apls');
	}
	public function destroy($id)
	{
		if ($this->_checkRedirectAplUser()) {
			return redirect()->to('/apl/facebook');
		}
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		$apl = \App\Apl::findRowById($id);
		if (!$user || $user->id != $apl->user_id) {
			abort(403, '不正です');
		} else {
			$this->_data['user'] = $user;
			$this->_data['apl'] = $apl;
		}
		$apl->del_flag = 1;
		$apl->save();
		return redirect()->to('/apl/apls');
	}
}
