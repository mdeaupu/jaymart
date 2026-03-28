<?php
namespace App\Livewire;

use App\Models\Branches;
use Livewire\Component;
use Livewire\WithPagination;

class BranchManagement extends Component
{
    use WithPagination;

    public $name, $address, $branchId;
    public $isOpen = false;
    public $confirmingDeletion = false;

    public function render()
    {
        return view('livewire.branch-management', [
            'branches' => Branches::latest()->paginate(5)
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

    public function delete($id)
    {
        try {
            $branch = Branches::findOrFail($id);
            $branch->delete();

            session()->flash('message', 'Cabang berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                session()->flash('error', 'Cabang tidak bisa dihapus karena masih memiliki data transaksi atau stok yang terkait.');
            } else {
                session()->flash('error', 'Terjadi kesalahan saat menghapus data.');
            }
        }
    }
}

