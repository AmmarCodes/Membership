{{ Form::open([
				'route' => ["members.{$action}", isset($member) ? $member->id : null],
				'method' => $action == 'store' ? 'post' : 'put'
			]) }}

{{ Form::textField('name', 'Name', Input::old('name', isset($member->name) ? $member->name : null )) }}

{{ Form::submit('Save', ['class' => 'btn btn-primary']) }}

{{ Form::close() }}
