<?php

namespace App\Livewire\Manager;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class StaffManagement extends Component
{
    public $name, $email, $password, $role, $userId;
    public $isOpen = false;
    public $confirmingStaffDeletion = false;

    public function render()
    {
        $managerBranchId = auth()->user()->branch_id;
        $tableNames = config('permission.table_names');

        $staff = User::where('branch_id', $managerBranchId)
            ->where('users.id', '!=', auth()->id())
            ->with('roles')
            ->leftJoin($tableNames['model_has_roles'], 'users.id', '=', $tableNames['model_has_roles'] . '.model_id')
            ->leftJoin($tableNames['roles'], $tableNames['model_has_roles'] . '.role_id', '=', $tableNames['roles'] . '.id')
            ->orderByRaw("
            CASE 
                WHEN {$tableNames['roles']}.name = 'supervisor' THEN 1
                WHEN {$tableNames['roles']}.name = 'cashier' THEN 2
                WHEN {$tableNames['roles']}.name = 'warehouse' THEN 3
                ELSE 4
            END ASC
        ")
            ->select('users.*')
            ->get();

        return view('livewire.manager.staff-management', [
            'staff' => $staff,
            'availableRoles' => Role::whereIn('name', ['supervisor', 'cashier', 'warehouse'])->get()
        ])->layout('layouts.app');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->userId = null;
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required',
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
        ]);

        $user = User::updateOrCreate(['id' => $this->userId], [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password ? Hash::make($this->password) : User::find($this->userId)->password,
            'branch_id' => auth()->user()->branch_id,
        ]);

        $user->syncRoles([$this->role]);

        session()->flash('message', $this->userId ? 'Data Staff Berhasil Diperbarui.' : 'Staff Baru Berhasil Ditambahkan.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->getRoleNames()->first();

        $this->isOpen = true;
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        $this->confirmingStaffDeletion = true;
    }

    public function delete()
    {
        if ($this->userId) {
            $user = User::find($this->userId);

            if ($user->id === auth()->id()) {
                session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
                $this->confirmingStaffDeletion = false;
                return;
            }

            $user->delete();
            $this->userId = null;
            $this->confirmingStaffDeletion = false;
            session()->flash('message', 'Data Staff Berhasil Dihapus.');
        }
    }
}
