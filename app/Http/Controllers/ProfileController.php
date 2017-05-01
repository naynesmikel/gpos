<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function profile($username){
      $user = User::whereUsername($username)->first();

      return view('user.profile', compact('user'));
    }

    public function edit($username)
    {
      $user = User::whereUsername($username)->first();

      return view('user.edit', compact('user'));
    }

    public function update(Request $request, $username)
    {
      $user = User::whereUsername($username)->first();
      $user->update($request->all());

      flash('Edit has been saved in the database!', 'success');

      return redirect("/profile/".$username);
    }
}
