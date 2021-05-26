<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\AvatarManager;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Requests\UserUpdateRequest;
use App\Exceptions\UnsupportedFileTypeException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->indexUsers(20);

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit-user', [$user]);

        $user_roles = Role::all()->toBase();

        return view('users.edit', compact('user', 'user_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('edit-user', [$user]);

        $user->update($request->all([
            'name',
            'age',
            'sex',
            'role_id',
        ]));

        if ($request->hasFile('avatar')) {
            $avatarManager = new AvatarManager();

            try {
                $path = $avatarManager->update($request->file('avatar'), $user->avatar_path);
            } catch (UnsupportedFileTypeException $e) {
                return back()->withInput()->withErrors([
                    'avatar' => $e->getMessage()
                ]);
            }

            $user->update(['avatar_path' => $path]);
        }

        return back()->with('user.update_status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, AvatarManager $avatarManager)
    {
        $this->authorize('edit-user', [$user]);

        $avatarManager->delete($user->avatar_path);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('user.delete_status', 'success');
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple(Request $request, AvatarManager $avatarManager)
    {
        $this->authorize('edit-user');

        $fields = Arr::where(
            $request->all(),
            fn ($value, $key) => str_starts_with($key, 'user-id') && $value === "on"
        );

        $userIds = array_map(
            fn ($field) => explode(':', $field, 2)[1],
            array_keys($fields)
        );

        $users = User::whereIn('id', $userIds)->get();

        // TODO Bad solution (delete-user-button)
        if ($users->count() === 1) {
            return $this->destroy($users->first(), $avatarManager);
        }

        foreach ($users as $user) {
            $avatarManager->delete($user->avatar_path);

            $user->delete();
        }

        return redirect()
            ->route('users.index')
            ->with('user.multiple_delete_status', 'success');
    }
}
