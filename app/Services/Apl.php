<?php
namespace App\Services;
/**
 * apl情報
 * singletonで使用
 */
class Apl
{
	private $_id;
	private $_code = "poke";
	private $_domain;
	private $_name = "ポケモンGOしようぜ";
	private $_apl;
	public function setCode($code)
	{
		$this->_apl = \App\Apl::findRowByCode($code);
		if ($this->_apl) {
			$this->_id = $this->_apl->id;
			$this->_name = $this->_apl->name;
		}
	}
	public function setDomain($domain) {
		$this->_domain = $domain;
	}
	public function getRow()
	{
		return $this->_apl;
	}
	public function getDomain()
	{
		return $this->_domain;
	}
	public function getCode()
	{
		return $this->_code;
	}
	public function getName()
	{
		return $this->_name;
	}
	public function getId()
	{
		return $this->_id;
	}
}
