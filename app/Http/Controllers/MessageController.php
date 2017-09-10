<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
class MessageController extends Controller
{
	public function __construct()
	{
		$this->_checkUse();
		if (!Session::get('fuser_id')) {
			abort(403, '不正です');
		}
		$user = \App\User::findRowExistsById(Session::get('fuser_id'));
		if (!$user) {
			abort(403, "あなたは会員ではありません");
		}
		$this->_checkApl();
		$this->_checkAplSessionUser();
	}
	public function index()
	{
		$self_fuser_id = Session::get('fuser_id');
		$messages = \App\Message::findAllByFuserIdOrToFuserId($self_fuser_id, $self_fuser_id);
		$messages = app('App\Services\Message')->getObjectsByRecords($messages);
		$this->_data['messages'] = $messages;
		// メッセージのnew_Flagを消す
		$fuser = \App\User::findRowExistsById(Session::get('fuser_id'));
		$fuser->new_message_cnt = 0;
		$fuser->save();
		$this->_data['self_fuser_id'] = $self_fuser_id;
		return view('messages.index', $this->_data);
	}
	public function create($match_id)
	{
		$match = \App\Match::find($match_id);
		switch (Session::get('fuser_id')) {
			case $match->fuser_id:
			case $match->guest_fuser_id:
				break;
			default:
				abort(403, 'security error');
		}
		$self_fuser_id = Session::get('fuser_id');
		$to_fuser_id = $match->guest_fuser_id;
		if ($self_fuser_id == $to_fuser_id) {
			$to_fuser_id = $match->fuser_id;
		}
		$to_fuser = \App\User::findRowExistsById($to_fuser_id);
		$self_fuser = \App\User::findRowExistsById($self_fuser_id);
		$messages = \App\Message::findAllByMatchIdAndFuserIdOrToFuserId(
					$match_id, $self_fuser_id, $self_fuser_id);
		$messages = app('App\Services\Message')->getObjectsByRecords($messages);
		$this->_data['messages'] = $messages;
		$this->_data['match'] = $match;
		$this->_data['self_fuser_id'] = $self_fuser_id;
		$this->_data['self_fuser'] = $self_fuser;
		$this->_data['to_fuser'] = $to_fuser;
		return view('messages.create', $this->_data);
	}
	public function store(Request $request)
	{
		$match = \App\Match::find($request->match_id);
		switch (Session::get('fuser_id')) {
			case $match->fuser_id:
			case $match->guest_fuser_id:
				break;
			default:
				abort(403, 'security error');
		}
		$this->validate($request, [
			'text' => 'required|max:255',
		]);
		$to_fuser_id = $match->fuser_id;
		if ($match->fuser_id == Session::get('fuser_id')) {
			$to_fuser_id = $match->guest_fuser_id;
		}
		$message = \App\Message::insertFuserIdToFuserIdTextMeetIdMatchId(
			Session::get('fuser_id'),
			$to_fuser_id,
			$request->text,
			$match->meet_id,
			$request->match_id
		);
		app('App\Services\EmailSend')
			->messageByFuserIdToFuserIdTextMeetIdMatchId(
				Session::get('fuser_id'),
				$to_fuser_id,
				$request->text,
				$match->meet_id,
				$request->match_id
			);
		return redirect()->to($this->_apl_code_uri.'/message/create/match_id/'.$request->match_id);
	}
	public function show($id)
	{
		$message = \App\Message::find($id);
		$this->_data['message'] = $message;
		return view('messages.show', $this->_data);
	}
	public function edit($id)
	{
		$message = \App\Message::find($id);
		$this->_data['message'] = $message;
		return view('messages.edit', $this->_data);
	}
	public function update(Request $request, $id)
	{
		$message = \App\Message::find($id);
		$message->name = $request->name;
		$message->email = $request->email;
		$message->save();
		return redirect()->to($this->_apl_code_uri.'/message');
	}
	public function destroy($id)
	{
		$message = \App\Message::find($id);
		$message->delete();
		return redirect()->to($this->_apl_code_uri.'/message');
	}
}
