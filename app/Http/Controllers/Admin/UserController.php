<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the user list.
     */
    public function index(): View
    {
        $users = User::query()
            ->orderBy('username')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the user creation form.
     */
    public function create(): View
    {
        return view('admin.users.create', ['roleOptions' => UserRole::cases()]);
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the user editing form.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roleOptions' => UserRole::cases(),
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (! filled($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove a user that is not active and has no loan history.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ((int) auth()->id() === $user->id_user) {
            return $this->errorRedirect('Akun yang sedang digunakan tidak dapat dihapus.');
        }

        if ($user->peminjaman()->exists()) {
            return $this->errorRedirect('Pengguna tidak dapat dihapus karena sudah memiliki riwayat peminjaman.');
        }

        try {
            $user->delete();
        } catch (QueryException $exception) {
            if ((string) $exception->getCode() !== '23000') {
                throw $exception;
            }

            return $this->errorRedirect('Pengguna tidak dapat dihapus karena sudah memiliki riwayat peminjaman.');
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    private function errorRedirect(string $message): RedirectResponse
    {
        return redirect()
            ->route('admin.users.index')
            ->with('error', $message);
    }
}
