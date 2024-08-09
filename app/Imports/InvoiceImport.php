<?php

namespace App\Imports;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToModel;

class InvoiceImport implements ToModel
{
    public function model(array $row)
    {
        return new Invoice([
            'serie' => $row[0],
            'base' => $row[1],
            'igv' => $row[2],
            'total' => $row[3],
            'user_id' => Auth::id(),
            'created_at' =>  is_numeric($row[4]) ? Carbon::instance(Date::excelToDateTimeObject($row[4])) : Carbon::createFromFormat('d/m/Y', $row[4]),
        ]);
    }
}
