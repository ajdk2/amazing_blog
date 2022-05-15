<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'title' => 'Users',
            'url' => '',
        ];

        $users = User::select([
            'id',
            'first_name',
            'last_name',
            'email',
            'is_enabled',
            'created_at',
        ])->where('id', '!=', auth()->id())->paginate(2);

        return view('admin.user.index', [
            'breadcrumbs' => $breadcrumbs,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'title' => 'Users',
            'url' => route('admin.user.index'),
        ];

        $breadcrumbs[] = [
            'title' => 'Add New User',
            'url' => '',
        ];

        return view('admin.user.create', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'password_confirmation ' => 'confirmed',
            'status' => 'boolean|required',
        ]);

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'is_enabled' => $validated['status'],
        ]);

        return redirect(route('admin.user.index'))->with('status', 'User created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'title' => 'Users',
            'url' => route('admin.user.index'),
        ];

        $breadcrumbs[] = [
            'title' => 'Edit User',
            'url' => '',
        ];

        $user = User::find($id);

        return view('admin.user.edit', [
            'user' => $user,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $validated = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => [
                Rule::unique('users')->ignore($user->id),
                'email'
            ],
            'password' => 'nullable',
            'password_confirmation ' => 'nullable|confirmed',
            'status' => 'boolean|required',
        ]);

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->is_enabled = $validated['status'];

        if (isset($validated['password'])) {
            $user->password =  bcrypt($validated['password']);
        }

        $user->save();

        return redirect(route('admin.user.index'))->with('status', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        }

        return redirect()->back();
    }
}
