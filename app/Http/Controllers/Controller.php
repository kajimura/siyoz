<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Session;
class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
	protected $_data = [];
	protected $_cnt = 0;
	protected $_controllerName = "";
	protected $_actionName = "";
	protected $_cacheIdPrefix = 'SIYOZ_CONTROLLER_35_';
	protected $_apl;
	protected function __construct()
	{
		$this->_cacheIdPrefix .= \Config::get('cache.prefix');
	}
	protected function _checkUse()
	{
		if (Session::get('fuser_id') == 1234561234) {
			abort(403, 'オープンまでしばらくお待ちください');
		}
	}
	protected function _checkApl()
	{
		$apl = app('App\Services\Apl'); // singleton
		$apl_code_uri = "";
		if (preg_match("!^(siyoz-test|siyoz.)!", \Request::server('HTTP_HOST'))) {
			$apl_code = "";
			if (preg_match("!^/([_\w]+)!", \Request::server('REQUEST_URI'), $matches)) {
				$apl_code = $matches[1];
				$apl_code_uri = "/".$apl_code;
			}
			$apl->setCode($apl_code);
			if ($apl_code == "poke" || $apl_code == "game") {
				abort("404", "このページは存在しません。サブドメインが有効なので、そちらを利用ください。");
			}
		} elseif (preg_match("!^([_\w]+)(.siyoz-test|.siyoz.)!", \Request::server('HTTP_HOST'), $matches)) {
			$apl->setCode($matches[1]);
		}
		$apl->setDomain(\Request::server('HTTP_HOST'));
		$this->_apl_code_uri = $apl_code_uri;
		$this->_apl = $apl->getRow();
		$this->_data['apl_code_uri'] = $this->_apl_code_uri;
		$this->_data['apl_name'] = $apl->getName();
		$this->_data['apl_id'] = $apl->getId();
		$this->_cacheIdPrefix .= "_".$apl->getId()."_";
	}
	protected function _checkAplSessionUser()
	{
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		if ($this->_apl->id != $user->apl_id) {
			abort(403, 'セッションが存在しません。ログインしてください。');
		}
	}
	protected function _checkAplUser($user)
	{
		if ($this->_apl->id != $user->apl_id) {
			abort(403, 'ユーザーが存在しません');
		}
	}
	protected function _getTitle()
	{
		$addstr = "";
		if (\Request::get('page') >= 2) {
			$addstr = " - " . \Request::get('page') . "ページ";
		}
		if ($this->_cnt) {
			$addstr = $this->_cnt . "件" . $addstr;
		}
		if ($this->_controllerName) {
			$addstr = $this->_controllerName . $addstr;
		}
		if ($addstr && $this->_actionName) {
			$addstr = " - " . $addstr;
		}
		$name = $this->_actionName . $addstr;
		// $name = str_replace(":", " - ", $name);
		if ($name) {
			$name = $name . " | ";
		}
		return $name . $this->_apl->title;
	}
	protected function _getKeywords()
	{
		$addstr = "";
		if (\Request::get('page') >= 2) {
			$addstr = "," . \Request::get('page')."ページ";
		}
		if ($this->_controllerName) {
			$addstr = $this->_controllerName . $addstr;
		}
		if ($addstr && $this->_actionName) {
			$addstr = "," . $addstr;
		}
		$name = $this->_actionName . $addstr;
		// $name = str_replace(":", ",", $name);
		if ($name) {
			$name = $name . ",";
		}
		return $name . $this->_apl->keywords;
	}
	protected function _getDescription()
	{
		$addstr = "";
		if (\Request::get('page') >= 2) {
			$addstr .= " - " . \Request::get('page')."ページ";
		}
		if ($this->_controllerName) {
			$addstr = $this->_controllerName . $addstr;
		}
		if ($addstr && $this->_actionName) {
			$addstr = " - " . $addstr;
		}
		$name = $this->_actionName . $addstr;
		if ($name) {
			$name = $name . "。";
		}
		return $name . $this->_apl->description;
	}
	protected function postDispatchTitle()
	{
		$this->_data['title'] = $this->_getTitle();
		$this->_data['keywords'] = $this->_getKeywords();
		$this->_data['description'] = $this->_getDescription();
	}
}
