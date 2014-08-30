@extends('master')

@section('content')

<ol class="breadcrumb">
	<li>{{ link_to_action('MembersController@index', 'Members') }}</li>
	<li>New</li>
</ol>



@stop
