<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$data = [];
		$data['apl_code_uri'] = "";
		$data['apl_name'] = "";
		print "hoge";exit;
		return view('home', $data)->render();
//        return view('home');
    }
}
