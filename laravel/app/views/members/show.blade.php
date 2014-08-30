@extends('master')

@section('content')

<ol class="breadcrumb">
	<li>{{ link_to_route('members.index', 'Members') }}</li>
	<li>View</li>
</ol>

Name: {{ $member->name }}

@stop
