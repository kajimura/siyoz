<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Session;
class IndexController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_checkApl();
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$cacheId = $this->_cacheIdPrefix . "_74_" . md5($request->url(). "_".$this->_apl_code_uri);
		if (Cache::has($cacheId)) {
			return Cache::get($cacheId);
		}
		if (!$this->_apl) {
			return redirect()->to('/apl');
		}
		if ($this->_apl->id == 1) {
			$meets = \App\Meet::findAllSample(6);
		} else {
			$meets = \App\Meet::findAllByAplId($this->_apl->id, 6);
		}
		$meets = app('App\Services\Meet')->getObjectsByRecords($meets);
		$this->_data['meets'] = $meets;
		$this->postDispatchTitle();
		if ($this->_apl->code == "poke" || $this->_apl->code == "game") {
			$html = view('indexs/'.$this->_apl->code, $this->_data)->render();
		} elseif ($this->_apl->code) {
			$html = view('indexs/index', $this->_data)->render();
		} else {
			die("not found");
		}
		Cache::put($cacheId, $html, 60);
		return $html;
	}

}
