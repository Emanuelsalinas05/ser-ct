<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetallePrestacion;
use Datatables;
use App\Http\Requests\CreateValidationRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class DatasExportController extends Controller
{

    public function fileImportExport()
    {
       return view('file-import');
    }


    public function fileExport(Request $request)
    {
        return (new ProductsExport)->download('solicitudes.xlsx');
        //return Excel::download(new RegistrosExport, 'solicitudes-periodo-sabatico.xlsx');
    }


    public function fileImport(Request $request)
    {
       // Excel::import(new RegistrosImport, $request->file('file')->store('temp'));
        //return back();
    }




}
