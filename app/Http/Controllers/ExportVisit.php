<?php

namespace App\Http\Controllers;

use App\Exports\ExportReportVisit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportVisit extends Controller
{
    public function export()
    {
        //$type_id = request('tableFilters.type.value');
       // return 'hello world '.$type_id;

       $customer_id    = request('tableFilters.customer_name.value');
       $user_sales_id  = request('tableFilters.name.value');
       $start_date     = request('tableFilters.start_date.tanggal_awal');
        $end_date       = request('tableFilters.start_date.tanggal_akhir');
       $date_filter    = array($start_date, $end_date);

       return Excel::download(new ExportReportVisit($customer_id, $user_sales_id, $date_filter), 'ReportVisit.xlsx');
    }
}
