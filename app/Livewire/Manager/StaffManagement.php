<?php

namespace App\Livewire\Manager;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class StaffManagement extends Component
{
    public $name, $email, $password, $role, $userId;
    public $isModalOpen = 0;

    public function render()
    {
        $managerBranchId = auth()->user()->branch_id;

        return view('livewire.manager.staff-management', [
            'staff' => User::where('branch_id', $managerBranchId)
                ->where('id', '!=', auth()->id())
                ->with('roles')
                ->get(),

            'availableRoles' => Role::whereIn('name', ['kasir', 'staff'])->get()
        ])->layout('layouts.app');
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

        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->userId = null;
    }
}
