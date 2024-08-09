<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class InvoiceBaseExport implements FromCollection, WithCustomStartCell, Responsable
{
    use Exportable;

    private $filters;

    private $fileName = 'invoice_base.xlsx';
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Invoice::filter($this->filters)->get();
    }

    public function startCell(): string
    {
        return 'A2';
    }
}
