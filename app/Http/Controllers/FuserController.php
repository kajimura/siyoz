<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FuserController extends Controller
{
	public function index()
	{
		$fusers = \App\User::get();
		$data = ['fusers' => $fusers];
		return view('fusers.index', $data);
	}
	public function create()
	{
		return view('fusers.create');
	}
	public function store(Request $request)
	{
		$user = \App\User::create();
		$user->name = $request->name;
		$user->email = $request->email;
		$user->save();
		return redirect()->to($this->_apl_code_uri.'/fuser');
	}
	public function show($id)
	{
		$fuser = \App\User::findRowExistsById($id);
		$this->_data['fuser'] = $fuser;
		return view('fusers.show', $this->_data);
	}
	public function edit($id)
	{
		$fuser = \App\User::findRowExistsById($id);
		$this->_data['fuser'] = $fuser;
		return view('fusers.edit', $this->_data);
	}
	public function update(Request $request, $id)
	{
		$user = \App\User::findRowExistsById($id);
		$user->name = $request->name;
		$user->email = $request->email;
		$user->save();
		return redirect()->to($this->_apl_code_uri.'/fuser');
	}
	public function destroy($id)
	{
		$user = \App\User::findRowExistsById($id);
		$user->del_flag = 1;
		$user=.save();
		return redirect()->to($this->_apl_code_uri.'/fuser');
	}
}
