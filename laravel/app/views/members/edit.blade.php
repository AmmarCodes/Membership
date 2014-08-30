@extends('master')

@section('content')

<ol class="breadcrumb">
	<li>{{ link_to_route('members.index', 'Members') }}</li>
	<li>Edit</li>
</ol>

@include('members.form', ['action' => 'update', 'member' => $member])

{{ Form::open(['route' => ['members.destroy', $member->id], 'method' => 'delete'])}}

{{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}

{{ Form::close() }}

@stop
