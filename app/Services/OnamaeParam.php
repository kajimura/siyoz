<?php

namespace App\Services;

class OnamaeParam
{
	// 確認画面時のFormパラメータ
	public function getConformParam($token)
	{
		$ns = [
			'hostName1[]' => 'siyoz.net',
			'recordType1[]' => 'NS',
			'ttl1[]' => '86400',
			'recValue1[]' => '01.dnsv.jp',
			'mxPreference1[]' => '',
			'keyTag1[]' => '',
			'alg1[]' => '',
			'digestType1[]' => '',
			'digest1[]' => '',
			'weightValue1[]' => '',
			'portValue1[]' => '',
			'cbo_status_record1[]' => 1, // 有効
			'hdd_status_record1[]' => 1,
			'chk_checkdomain1[]' => 0,
		];
		$ip = [
			'hostName1[]' => 'siyoz.net',
			'recordType1[]' => 'A',
			'ttl1[]' => '3600',
			'recValue1[]' => '133.130.126.208',
			'mxPreference1[]' => '',
			'keyTag1[]' => '',
			'alg1[]' => '',
			'digestType1[]' => '',
			'digest1[]' => '',
			'weightValue1[]' => '',
			'portValue1[]' => '',
			'cbo_status_record1[]' => 1, // 有効
			'hdd_status_record1[]' => 1,
			'chk_checkdomain1[]' => 0,
		];
		$domains = [];
		for ($i = 1; $i <= 4; $i++) {
			$ns['recValue1[]'] = '0'.$i.'.dnsv.jp';
			array_push($domains, $ns);
		}
		for ($i = 5; $i <= 9; $i++) {
			$ip['hostName1[]'] = 'siyoz.net';
			if ($i == 6) {
				$ip['hostName1[]'] = 'poke.siyoz.net';
			} elseif ($i == 7) {
				$ip['hostName1[]'] = 'game.siyoz.net';
			} elseif ($i == 8) {
				$ip['hostName1[]'] = 'sample.siyoz.net';
			} elseif ($i == 9) {
				$ip['hostName1[]'] = 'sample2.siyoz.net';
			}
			array_push($domains, $ip);
		}
		$keys = [];
		$domains_key = [];
		foreach ($ns as $key => $value) {
			$key_name = str_replace("[]", "", $key);
			$domains_key[$key_name] = [];
			foreach ($domains as $ns1) {
				array_push($domains_key[$key_name], $ns1[$key]);
			}
		}
		$form_params = [
			'domain' => 'siyoz.net',
			'_token' => $token,
			'show_type_record' => 0,
			'hdd_domain_dnscontroll' => 'siyoz.net',
			'hdd_back' => '',
			'keySearchBack' => '',
			'indexAddrecord' => '',
			'nsDnsvFlg' => 1,
			'Totalrecord' => count($domains_key),
			
			'domain' => 'siyoz.net',
			'inter_or_exter' => 'external',
			'keyZoneListBack' => '',
			'keyListBack' => '',
			'target_source_url' => 'https://www.onamae.com/domain/navi/dns_manage/select',
		];
		return array_merge($domains_key, $form_params);
	}
	// 確定時のformパラメータ
	public function getCommitParam($token)
	{
		$form_params = $this->getConformParam($token);
		$form_params['resultCode'] = '';
		$form_params['keyDomainListBack'] = '';
		foreach ($form_params as $key => $domains) {
			if (preg_match("!1$!", $key)) {
				$key_0 = str_replace("1", "", $key);
				$form_params[$key_0] = $domains;
				unset($form_params[$key]);
			}
		}
		foreach ($form_params['recordType'] as $key => $value) {
			if ($value == 'A') {
				$form_params['recordType'][$key] = 20;
			} elseif ($value == 'NS') {
				$form_params['recordType'][$key] = 10;
			}
		}
		foreach ($form_params['recordType'] as $key => $value) {
			$form_params['recordstatus'][$key] = 1;
			$form_params['delete'][$key] = 0;
		}
		$form_params['_token'] = $token;
		unset($form_params['show_type_record']);
		unset($form_params['hdd_domain_dnscontroll']);
		unset($form_params['hdd_back']);
		unset($form_params['keySearchBack']);
		unset($form_params['indexAddrecord']);
		unset($form_params['Totalrecord']);
		return $form_params;
	}
	public function getTokenByContent($body)
	{
		$lines = preg_split("!\r\n|\r|\n!", $body);
		$token = "";
		if (preg_match("!\"([\w]{32})\"!", $body, $matches)) {
			$token = $matches[1];
		}
		return $token;
	}
}
