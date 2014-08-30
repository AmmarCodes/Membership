@extends('master')

@section('content')

<ol class="breadcrumb">
	<li>{{ link_to_route('members.index', 'Members') }}</li>
	<li>New</li>
</ol>

@include('members.form', ['action' => 'store'])


@stop
