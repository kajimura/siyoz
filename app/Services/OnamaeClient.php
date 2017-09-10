<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class OnamaeClient extends \GuzzleHttp\Client
{
	public $headers = [];
	public function __construct()
	{
		$base_url = 'https://www.onamae.com';
		parent::__construct( [
			'base_uri' => $base_url,
			'cookies' => true
		] );
		$this->headers = [
			'User-Agent'				=> 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36',
		];
	}
}

