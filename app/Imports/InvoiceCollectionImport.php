<?php

namespace App\Imports;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvoiceCollectionImport implements ToCollection, WithCustomCsvSettings, WithGroupedHeadingRow, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (count($row) >= 5) {
                $invoice = Invoice::create([
                    'serie' => $row['serie'],
                    'base' => $row['base'],
                    'igv' => $row['igv'],
                    'total' => $row['total'],
                    'user_id' => Auth::id(),
                    //Verifica el formato de la columna si es Texto o Fecha
                    'created_at' =>  is_numeric($row[4]) ? Carbon::instance(Date::excelToDateTimeObject($row['created_at'])) : Carbon::createFromFormat('d/m/Y', $row['created_at']),
                ]);
            } else {
                die('no tiene filas completas');
            }
            // Aquí podemos crear mas cosas como crear otro registro con otro modelo
            //Example
            /*Article::create([
                'invoice' => $invoice->id,
            ]);*/
        }
    }
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ';',
        ];
    }

}
