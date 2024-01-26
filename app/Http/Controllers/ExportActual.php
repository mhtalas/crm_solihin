<?php

namespace App\Http\Controllers;

use App\Exports\ExportReportActual;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportActual extends Controller
{
    public function export()
    {
        //$type_id = request('tableFilters.type.value');
       // return 'hello world '.$type_id;

       return Excel::download(new ExportReportActual, 'ReportActual.xlsx');
    }
}
