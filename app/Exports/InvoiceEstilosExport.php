<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceEstilosExport implements FromCollection, Responsable, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    private $filters;

    //! Exportable
    private $fileName = 'invoice_estilo.xlsx';
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Invoice::filter($this->filters)->get();
    }

    //! WithHeadings
    public function headings(): array
    {
        return [
            'Serie',
            'Correlativo',
            'Base',
            'IGV',
            'Total',
            'Usuario',
            'Correo',
            'Fecha',
        ];
    }

    //! WithMapping
    public function map($invoice): array
    {
        return [
            $invoice->serie,
            $invoice->correlative,
            $invoice->base,
            $invoice->igv,
            $invoice->total,
            $invoice->user->name,
            $invoice->user->email,
            $invoice->created_at,
            // Date::dateTimeToExcel($invoice->created_at),
        ];
    }

    //! Se quito la clase WithColumnFormatting
    // public function columnFormats(): array
    // {
    //     return [
    //         'H' => 'dd/mm/yyy',
    //     ];
    // }

    //! WithStyles
    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Invoices'); // El nombre de la hoja

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                // 'name' => 'Arial',
                'size' => 12,
            ],
            //! Opcional: aplicar un color de fondo a los encabezados
            'fill' => [
                // 'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'fillType'   => 'solid',
                'startColor' => ['argb' => 'C5D9F1'],
            ]
        ]);

        // Aplicar bordes a todas las celdas de la tabla
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:H' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    // 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'borderStyle' => 'thin',
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }
}
