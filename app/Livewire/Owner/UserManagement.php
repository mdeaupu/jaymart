<?php

namespace App\Livewire\Owner;

use App\Models\Branches;
use Livewire\Component;
use App\Models\User;
use App\Models\Branch;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $name, $email, $password, $userId, $role, $branch_id;
    public $isOpen = false;
    public $confirmingUserDeletion = false;
    protected $updatesQueryString = ['userId'];

    public function render()
    {
        $tableNames = config('permission.table_names');

        $users = User::with(['roles', 'branch'])
            ->select('users.*')
            ->leftJoin($tableNames['model_has_roles'], 'users.id', '=', $tableNames['model_has_roles'] . '.model_id')
            ->leftJoin($tableNames['roles'], $tableNames['model_has_roles'] . '.role_id', '=', $tableNames['roles'] . '.id')
            ->where($tableNames['roles'] . '.name', '!=', 'owner')
            ->orderByRaw("
            CASE 
                WHEN {$tableNames['roles']}.name = 'owner' THEN 1
                WHEN {$tableNames['roles']}.name = 'manager' THEN 2
                WHEN {$tableNames['roles']}.name = 'supervisor' THEN 3
                WHEN {$tableNames['roles']}.name = 'cashier' THEN 4
                WHEN {$tableNames['roles']}.name = 'warehouse' THEN 5
            END ASC
        ")
            ->latest('users.created_at')
            ->paginate(11);

        return view('livewire.owner.user-management', [
            'users' => $users,
            'branches' => Branches::all() ?? [],
            'roles' => Role::all() ?? []
        ])->layout('layouts.app');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->userId = null;
        $this->role = '';
        $this->branch_id = '';
        $this->resetErrorBag();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required',
            'branch_id' => 'nullable|exists:branches,id',
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
        ]);

        $user = User::updateOrCreate(['id' => $this->userId], [
            'name' => $this->name,
            'email' => $this->email,
            'branch_id' => $this->branch_id ?: null,
            'password' => $this->password ? Hash::make($this->password) : User::find($this->userId)->password,
        ]);

        $user->syncRoles($this->role);

        session()->flash('message', $this->userId ? 'User Berhasil Diperbarui.' : 'User Berhasil Dibuat.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->branch_id = $user->branch_id;
        $this->role = $user->getRoleNames()->first();

        $this->isOpen = true;
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        $this->confirmingUserDeletion = true;
    }

    public function delete()
    {
        if ($this->userId) {
            $user = User::find($this->userId);

            if ($user->id === auth()->id()) {
                session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
                $this->confirmingUserDeletion = false;
                return;
            }

            $user->delete();
            $this->userId = null;
            $this->confirmingUserDeletion = false;
            session()->flash('message', 'User Berhasil Dihapus.');
        }
    }
}