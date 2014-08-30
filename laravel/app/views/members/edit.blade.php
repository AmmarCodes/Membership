@extends('master')

@section('content')

<ol class="breadcrumb">
	<li>{{ link_to_action('MembersController@index', 'Members') }}</li>
	<li>Edit</li>
</ol>



@stop
