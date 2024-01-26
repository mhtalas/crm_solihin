<?php

namespace App\Http\Controllers;

use App\Exports\ExportReportProposed;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportProposed extends Controller
{
    public function export()
    {
       /*
       http://127.0.0.1:8000/admin/report-proposeds?
            tableFilters[start_date][tanggal_awal]=2023-12-26&
            tableFilters[start_date][tanggal_akhir]=2024-01-26&
            tableFilters[name][value]=null&
            tableFilters[customer_name][value]=4
        */

        $customer_id    = request('tableFilters.customer_name.value');
        $user_sales_id  = request('tableFilters.name.value');
        $start_date     = request('tableFilters.start_date.tanggal_awal');
        $end_date       = request('tableFilters.start_date.tanggal_akhir');
        $date_filter    = array($start_date, $end_date);
        // return 'hello world '.$type_id;

       return Excel::download(new ExportReportProposed($customer_id, $user_sales_id, $date_filter), 'ReportProposed.xlsx');
    }
    
}
