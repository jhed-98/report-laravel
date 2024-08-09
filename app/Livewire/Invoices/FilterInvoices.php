<?php

namespace App\Livewire\Invoices;

use App\Exports\InvoiceBaseExport;
use App\Exports\InvoiceEstilosExport;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class FilterInvoices extends Component
{
    use WithPagination;

    public $filters = [
        'serie' => '',
        'fromNumber' => '',
        'toNumber' => '',
        'fromDate' => '',
        'toDate' => '',
    ];

    public function limpiar(){
        $this->reset();
    }

    public function generarReport()
    {
        //! Formato de exportación predeterminada del excel
        // return Excel::download(new InvoiceBaseExport, 'invoices.xlsx');
        //! Una vez implementado Exportable
        // return (new InvoiceBaseExport())->download();
        //! Una vez implementado Responsable
        // return new InvoiceBaseExport($this->filters);
        //! Exportación con estilos
        return new InvoiceEstilosExport($this->filters);
    }

    public function render()
    {
        // Metodo para pasar los parametros de los filtros
        $invoices = Invoice::filter($this->filters)->paginate(10);

        return view('livewire.invoices.filter-invoices', compact('invoices'));
    }
}
