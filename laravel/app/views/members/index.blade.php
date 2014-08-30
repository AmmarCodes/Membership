@extends('master')

@section('content')

<ol class="breadcrumb">
	<li>{{ link_to_action('MembersController@index', 'Members') }}</li>
</ol>

{{ link_to_action('MembersController@create', 'New Member', null, ['class' => 'btn btn-primary']) }}

<br>

@if(isset($members) and count($members))

	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Edit</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($members as $member)
				<tr>
					<td>{{ ++$item_counter }}</td>
					<td>{{ link_to_action('MembersController@show', $member->name, [ $member->id ] ) }}</td>
					<td><a href="{{ URL::action('MembersController@edit', [ $member->id ]) }}"><i class="fa fa-edit"></i></a>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $members->links() }}

@endif

@stop
