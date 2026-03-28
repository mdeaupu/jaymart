<?php

namespace App\Livewire;

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

    // Properti untuk Form
    public $name, $email, $password, $userId, $role, $branch_id;

    // Properti untuk UI State
    public $isOpen = false;
    public $confirmingUserDeletion = false;

    // Reset error setiap kali input berubah
    protected $updatesQueryString = ['userId'];

    public function render()
    {
        return view('livewire.user-management', [
            // Ambil data di sini agar tidak pernah NULL saat di-render ulang
            'users' => User::with(['roles', 'branch'])->latest()->paginate(10),
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
            User::find($this->userId)->delete();
            $this->confirmingUserDeletion = false;
            session()->flash('message', 'User Berhasil Dihapus.');
        }
    }
}