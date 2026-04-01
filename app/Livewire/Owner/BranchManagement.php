<?php
namespace App\Livewire\Owner;

use App\Models\Branches;
use Livewire\Component;
use Livewire\WithPagination;

class BranchManagement extends Component
{
    use WithPagination;

    public $name, $address, $branchId;
    public $isOpen = false;
    public $confirmingBranchDeletion = false;
    public $branchIdBeingDeleted = null;

    public function confirmBranchDeletion($id)
    {
        $this->branchIdBeingDeleted = $id;
        $this->confirmingBranchDeletion = true;
    }


    public function render()
    {
        return view('livewire.owner.branch-management', [
            'branches' => Branches::latest()->paginate(11)
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->address = '';
        $this->branchId = null;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:5',
        ]);

        Branches::updateOrCreate(['id' => $this->branchId], [
            'name' => $this->name,
            'address' => $this->address,
        ]);

        session()->flash('message', $this->branchId ? 'Cabang diperbarui' : 'Cabang berhasil didaftarkan');
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $branch = Branches::findOrFail($id);
        $this->branchId = $id;
        $this->name = $branch->name;
        $this->address = $branch->address;
        $this->isOpen = true;
    }

    public function delete()
    {
        if ($this->branchIdBeingDeleted) {
            try {
                $branch = Branches::findOrFail($this->branchIdBeingDeleted);
                $branch->delete();

                session()->flash('message', 'Cabang berhasil dihapus.');
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == "23000") {
                    session()->flash('error', 'Cabang tidak bisa dihapus karena masih memiliki data terkait.');
                } else {
                    session()->flash('error', 'Terjadi kesalahan saat menghapus data.');
                }
            }

            $this->confirmingBranchDeletion = false;
            $this->branchIdBeingDeleted = null;
        }
    }
}

