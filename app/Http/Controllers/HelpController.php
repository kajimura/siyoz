<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
class HelpController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->_checkApl();
	}
	public function privacy(Request $request)
	{
		$cacheId = $this->_cacheIdPrefix . "_18_" . md5($request->url());
		if (Cache::has($cacheId)) {
			return Cache::get($cacheId);
		}
		$this->_actionName = "プライバシーポリシー";
		$this->postDispatchTitle();
		$html = view('helps.privacy', $this->_data)->render();
		Cache::put($cacheId, $html, 60 * 24 * 30);
		return $html;
	}
	public function condition(Request $request)
	{
		$cacheId = $this->_cacheIdPrefix . "_18_" . md5($request->url());
		if (Cache::has($cacheId)) {
			return Cache::get($cacheId);
		}
		$this->_actionName = "利用規約";
		$this->postDispatchTitle();
		$html = view('helps.condition', $this->_data)->render();
		Cache::put($cacheId, $html, 60 * 24 * 30);
		return $html;
	}
	public function company(Request $request)
	{
		$cacheId = $this->_cacheIdPrefix . "_18_" . md5($request->url());
		if (Cache::has($cacheId)) {
			return Cache::get($cacheId);
		}
		$this->_actionName = "運営会社";
		$this->postDispatchTitle();
		$html = view('helps.company', $this->_data)->render();
		Cache::put($cacheId, $html, 60 * 24 * 30);
		return $html;
	}
	public function wait(Request $request)
	{
		$cacheId = $this->_cacheIdPrefix . "_18_" . md5($request->url());
		if (Cache::has($cacheId)) {
			return Cache::get($cacheId);
		}
		$this->_actionName = "登録ありがとうございます";
		$this->postDispatchTitle();
		$html = view('helps.wait', $this->_data)->render();
		Cache::put($cacheId, $html, 60 * 24 * 30);
		return $html;
	}
}
