<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
class FlogoutController extends Controller
{
	public function __construct()
	{
		$this->_checkApl();
	}
	public function index()
	{
		Session::forget('name');
		Session::forget('fuser_id');
		return redirect()->to($this->_apl_code_uri.'/');
	}
}
