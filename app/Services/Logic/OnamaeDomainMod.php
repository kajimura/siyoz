<?php
namespace App\Services\Logic;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Services\Logic\ILogic;

// php artisan Onamae
// スクレイピングでOnamae.com更新
class OnamaeDomainMod implements ILogic
{
	private $_client;
	public function execLogic()
	{
		$this->_client = app('App\Services\OnamaeClient');
		$this->_httpTop();
		$this->_httpLogin();
		// $this->_httpDnsDomains();
		$token = $this->_httpDnsDetail();
		$token = $this->_httpDnsDetailConform($token);
		echo $this->_httpDnsDetailCommit($token);
	}
	private function _httpTop()
	{
		$path = "/domain/navi/domain.html";
		$response = $this->_client->get($path,
				[
					'allow_redirects' => true,
					'headers'		 => $this->_client->headers,
				]
		);
		return (string) $response->getBody()->getContents();
	}
	private function _httpLogin()
	{
		$path = "/domain/navi/domain.html";
		$response = $this->_client->post($path ,
			[
			   'allow_redirects' => true,
			   'headers'		 => $this->_client->headers,
			   'form_params'	 => [
					'request_uri' => 'https://www.onamae.com/domain/navi/domain.html?link=domain/navi/domain_renew/input',
					'username' => env('ONAMAE_USERNAME'),
					'password' => env('ONAMAE_PASSWORD'),
					"actFrm" => 'domain',
					"pc" => "",
					"et" => "login",
					'errorsessionFlg' => '',
				]
			]
		);
	}
	// DNS関連機能の設定画面(domain一覧)からのsiyozへ移動
	private function _httpDnsDomains()
	{
		$path = "/domain/navi/dns_manage/select";
		$response = $this->_client->post($path,
			[
				'allow_redirects' => true,
				'headers'		 => $this->_client->headers,
				'form_params'	 => [
					'domain' => 'siyoz.net',
					'keyDomainListBack' => '',
					'keyZoneListBack' => '',
					'inter_or_exter' => '',
				]
			]
		);
	}
	private function _httpDnsDetail()
	{
		// DNSレコード設定画面
		$path = "/domain/navi/dns_controll/input";
		$response = $this->_client->post($path,
			[
				'allow_redirects' => true,
				'headers'		 => $this->_client->headers,
				'form_params'	 => [
					'domain' => 'siyoz.net',
				]
			]
		);
		$body = $response->getBody()->getContents();
		$onamaeParam = app('App\Services\OnamaeParam');
		return $onamaeParam->getTokenByContent($body);
	}
	// DNS詳細設定入力から確認画面へ
	private function _httpDnsDetailConform($token)
	{
		// DNSレコード設定確認画面へ
		$path = "/domain/navi/dns_controll/confirm";
		$onamaeParam = app('App\Services\OnamaeParam');
		$form_params = $onamaeParam->getConformParam($token);
		$response = $this->_client->post($path,
			[
				'allow_redirects' => true,
				'headers'		 => $this->_client->headers,
				'form_params'	 => $form_params,
			]
		);
		$body = (string) $response->getBody()->getContents();
		return $onamaeParam->getTokenByContent($body);
	}
	private function _httpDnsDetailCommit($token)
	{
		// DNS管理画面完了処理
		$path = "/domain/navi/dns_controll/loading";
		$onamaeParam = app('App\Services\OnamaeParam');
		$form_params = $onamaeParam->getCommitParam($token);
		$response = $this->_client->post($path,
			[
				'allow_redirects' => true,
				'headers'		 => $this->_client->headers,
				'form_params'	 => $form_params,
			]
		);
		return (string) $response->getBody()->getContents();
	}
}
