<?php

class MembersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /members
	 *
	 * @return Response
	 */
	public function index()
	{
		$members = Member::paginate(Config::get('custom.per_page', 10));
		$item_counter = Config::get('custom.per_page', 10) * ($members->getCurrentPage() - 1);

		return View::make('members.index', ['members' => $members, 'item_counter' => $item_counter]);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /members/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('members.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /members
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /members/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$member = Member::findOrFail($id);
		return View::make('members.show', ['member' => $member]);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /members/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('members.edit');
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /members/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /members/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
