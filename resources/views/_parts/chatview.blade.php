<link rel="stylesheet" href="/assets/css/chat-talk.css" />
<div id="chat-frame">
	@foreach ($messages as $key => $message)
		@if ($message->fuser)
			@if ($message->text)
				@if ($self_fuser_id != $message->fuser->id)
					<p class="chat-talk">
						<span class="talk-icon">
							<a href="{{$apl_code_uri}}/prof/{{$message->fuser->id}}">
								<img src="
										{{$message->fuser->avatar}}
								" alt="tartgeticon" width="50px" height="50px" alt="{{$message->fuser->name}}" />
							</a>
<br />
<span class="talk-name">
{{$message->fuser->name}}
</span>
						</span>
						<span class="talk-content">
							{{$message->text}}<br />
							<span class="talk-date">{{$message->created_at}}</span>
						</span>
					</p>
				@else
					<p class="chat-talk mytalk">
						<span class="talk-icon">
							<a href="{{$apl_code_uri}}/prof/{{$message->fuser->id}}">
								<img src="
										{{$message->fuser->avatar}}
								" alt="tartgeticon" width="50px" height="50px" alt="{{$message->fuser->name}}" />
							</a>
<br />
<span class="talk-name">
{{$message->fuser->name}}
</span>
						</span>
						<span class="talk-content">
							{{$message->text}}<br />
							<span class="talk-date">{{$message->created_at}}</span>
						</span>
					</p>
				@endif
			@endif
			@if ($message->status_msg)
				<span class="chat-talk talk-system" align="center">{{$message->status_msg}}</span>
			@endif
		@endif
	@endforeach
	</div>
</div>
