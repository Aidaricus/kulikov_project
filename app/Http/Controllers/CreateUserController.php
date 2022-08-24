<?php

namespace App\Http\Controllers;

// CRUD
use App\Models\User;
use App\Models\Permission;
use App\Rules\ContainsPercent;
use App\Rules\PasswordsAreSame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Contains;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class CreateUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        if (Auth::user() == null) {
            return abort(403);
        }
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authorized_user = Auth::user();
        Gate::authorize('user-create', [$authorized_user]);
        $permissions = Permission::all();
        return view('users.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $confirmed_password = $request->input('confirm-password');
        $password = $request->input('password');
        $request->validate([
            'name' => ['required', new ContainsPercent],
            'email' => ['required', 'email:rfc', 'unique:users'],
            'password' => ['required', 'min:3', new PasswordsAreSame($confirmed_password, $password)], // confirm_password validation 
            'confirm-password' => 'required',
            'email_verifed_at' => 'datetime',
        ]);
        // Creating new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        // Ataching new permissions to user
        $user_perm = $request->input('perm');
        if ($user_perm) foreach ($user_perm as $key => $permission_id) {
            $user->permissions()->attach($key);
        }
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $authorized_user = Auth::user();
        $permissions = Permission::all();
        Gate::authorize('user-update', [$authorized_user]);
        return view('users.edit', compact(['user', 'permissions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required',],
            'email' => ['required', 'email:rfc', 'unique:users'],
            'password' => ['required', 'min:3'],
            'email_verifed_at' => 'datetime',
        ]);
        $authorized_user = Auth::user();
        Gate::authorize('user-update', [$authorized_user]);

        // Удаляем все permissions
        $user->permissions()->detach();
        $user_perm = $request->input('perm');
        if ($user_perm != null) {
            foreach ($user_perm as $key => $permission_id) {
                $user->permissions()->attach($key);
            }
        }
        $user->update($request->all());
        $user->update(['password' => Hash::make($request->password)]);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $authorized_user = Auth::user();
        Gate::authorize('user-delete', [$authorized_user]);
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'user deleted successfully');
    }
}
