<?php

namespace App\Http\Controllers;

use App\Imports\InvoiceCollectionImport;
use App\Imports\InvoiceImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    public function export()
    {
        return view('invoices.export');
    }
    public function import()
    {
        return view('invoices.import');
    }
    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        $file = $request->file('file');

        //! Devuelve la collecion q se envio del archivo
        // return Excel::toCollection(new InvoiceImport, $file);
        //! Import excel como ToModel
        // Excel::import(new InvoiceImport, $file);
        //! Import excel como ToCollection
        Excel::import(new InvoiceCollectionImport, $file);
    }

    public function importStoreFile(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        // verifica si se ha subido un archivo Excel
        if (!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
            die('No se ha seleccionado un archivo Excel.');
        }

        // obtenemos la ruta temporal del archivo subido
        $excelFilePath = $_FILES['file']['tmp_name'];

        // nombres de las columnas del encabezado
        $expectedHeaders = array('serie', 'base', 'igv', 'total', 'created_at');

        // carga el archivo Excel
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFilePath);

        // obtiene la hoja activa del archivo
        $worksheet = $spreadsheet->getActiveSheet();

        // obtiene la primera fila del archivo
        $firstRow = $worksheet->getRowIterator()->current();

        // obtiene los nombres de las celdas de la primera fila
        $headerNames = [];
        foreach ($firstRow->getCellIterator() as $cell) {
            $headerNames[] = $cell->getValue();
        }

        // Verifica si los nombres de las celdas de la primera fila coinciden con los nombres esperados
        if ($headerNames === $expectedHeaders) {
            // importar el archivo
            Excel::import(new InvoiceCollectionImport, $excelFilePath);
            return redirect()->back()->with(['type' => 'sucess', 'message' => 'Excel ó CSV con encabezado importado correctamente']);
        } else {
            // el archivo no tiene los encabezados esperados
            Excel::import(new InvoiceImport, $excelFilePath);
            return redirect()->back()->with(['type' => 'sucess', 'message' => 'Excel ó CSV con encabezado importado correctamente']);
        }
    }
}
