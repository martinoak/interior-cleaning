<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create([
            'name' => $request->name,
            'login' => $request->login,
            'password' => bcrypt($request->password),
            'api_token' => md5(uniqid(rand(), true)),
            'role' => $request->role,
        ]);

        return to_route('admin.users.index')->with('success', 'Uživatel byl úspěšně vytvořen.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view('admin.users.edit', [
            'user' => User::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'login' => $request->login,
            'password' => bcrypt($request->password),
            'api_token' => md5(uniqid(rand(), true)),
            'role' => $request->role,
        ]);

        return to_route('admin.users.index')->with('success', 'Uživatel byl úspěšně upraven.');
    }
}
