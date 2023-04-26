<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Requestt $request)
    {
        $search = $request->search;
        $users = User::where('name', 'LIKE', "%{$search}%") -> orWhere('lastname', 'LIKE', "%{$search}%") -> latest()->paginate();
        return view('users.index', ['users' => $users]);
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=> 'required',
            'lastname'=> 'required',
            'phone'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
        ]);

        $user->update([
            'name'=> $request->name,
            'lastname'=> $request->lastname,
            'phone'=> $request->phone,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);

        return redirect()->route('users.index', $user);
    }


    public function updateState(Request $request, User $user)
    {
        if ($request->state == "Habilitar") {

            $state = 1;
        } else {
            $state = 0;
        }

        $user->update([
            'state' => $state,
        ]);

        return back();
    }


    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
