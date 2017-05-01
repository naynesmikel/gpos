<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UsersController extends Controller
{
	public function index()
	{
		$users = User::where('admin', 0)->orderBy('name', 'ASC')->paginate(10);
		return view('admin.users.index', compact('users'));
	}

	public function create(){
		return view('admin.users.create');
	}

	public function store(Request $request){
		User::create($request->all());
		return 'success';
		return $request->all();
	}

	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$name = $user->name;

		$user->delete();

		flash($name . ' has been deleted in the database!', 'success');

		return redirect('/users');
	}
}
