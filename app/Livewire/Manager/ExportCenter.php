<?php

namespace App\Livewire\Manager;

use App\Models\Transactions;
use Carbon\Carbon;
use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;

class ExportCenter extends Component
{
    public $month;

    public function mount()
    {
        $this->month = Carbon::now()->format('Y-m');
    }

    public function exportExcel()
    {
        $transactions = $this->getBaseQuery()->get();

        return response()->streamDownload(function () use ($transactions) {
            (new FastExcel($transactions))->export('php://output', function ($transaction) {
                return [
                    'Invoice' => $transaction->invoice_number,
                    'Kasir' => $transaction->user->name ?? 'User Terhapus',
                    'Total' => $transaction->total_price,
                    'Tanggal' => $transaction->created_at->format('d-m-Y H:i')
                ];
            });
        }, 'laporan-penjualan-' . $this->month . '.xlsx');
    }

    private function getBaseQuery()
    {
        [$year, $month] = explode('-', $this->month);

        $managerBranchId = auth()->user()->branch_id;

        return Transactions::with('user')
            ->where('branch_id', $managerBranchId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);
    }
    public function exportPdf()
    {
        try {
            $query = $this->getBaseQuery();
            $transactions = $query->get();

            $pdf = DomPDF::loadView('livewire.pdf.sales-report', [
                'transactions' => $transactions,
                'branch' => auth()->user()->branch,
                'month' => $this->month
            ]);

            $pdf->setPaper('a4', 'portrait');

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, 'Laporan-' . $this->month . '.pdf', [
                'Content-Type' => 'application/pdf',
            ]);

        } catch (\Exception $e) {
            dd("Error DomPDF: " . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.manager.export-center')->layout('layouts.app');
    }
}
