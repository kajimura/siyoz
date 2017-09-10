<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Session;
class BlogController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		parent::_checkApl();
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, $code)
	{
		$cacheId = $this->_cacheIdPrefix . "_29_" . md5($request->url());
		if (Cache::has($cacheId)) {
			return Cache::get($cacheId);
		}
		if (preg_match("/^poke.siyoz/", $_SERVER['HTTP_HOST']) && $code == 1) {
			return \Redirect::to($this->_apl_code_uri.'/blog/pgoerr');
		}
		$filedir = __DIR__ . "/../../../resources/blogs/".$this->_apl->code;
		$kz = app('Kz_Core');
		$lines = $kz->get_file_array($filedir . "/" . $code.".txt");
		if (!$lines) die("not found page");
		$codes = $kz->get_dir_file($filedir ."/");
		$pages = [];
		foreach ($codes as $_code) {
			if (!preg_match("/.txt$/", $_code)) continue;
			$page = [];
			$page['code'] = str_replace(".txt", "", $_code);
			$page['name'] = $kz->get_file_data_1($filedir . "/" . $_code);
			$pages[] = $page;
		}
		$body_title = array_shift($lines);
		$this->_controllerName = $body_title;
		$this->_data['code'] = $code;
		$this->_data['body_title'] = $body_title;
		$this->_data['body'] = implode("<br />", $lines);
		$this->_data['pages'] = $pages;
		$this->postDispatchTitle();
		$html = view('blogs/index', $this->_data)->render();
		Cache::put($cacheId, $html, 60 * 24);
		return $html;
		// return view('blogs/index', $this->_data)->render();
	}

}
