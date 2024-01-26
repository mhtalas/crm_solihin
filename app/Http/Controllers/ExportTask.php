<?php

namespace App\Http\Controllers;

use App\Exports\ExportReportTask;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportTask extends Controller
{
    public function export()
    {
        //$type_id = request('tableFilters.type.value');
       // return 'hello world '.$type_id;

        $customer_id    = request('tableFilters.customer_name.value');
        $user_sales_id  = request('tableFilters.name.value');
        $start_date     = request('tableFilters.due_date.due_date_awal');
        $end_date       = request('tableFilters.due_date.due_date_akhir');
        $date_filter    = array($start_date, $end_date);

       return Excel::download(new ExportReportTask($customer_id, $user_sales_id, $date_filter), 'Task.xlsx');
    }
}
