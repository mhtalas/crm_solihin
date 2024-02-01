<?php

namespace App\Exports;

use App\Models\ProjectActual;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
#use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class ExportReportActual implements FromCollection, WithHeadings, WithMapping
{
    /* *
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return ProjectActual::select(
            //DB::raw("TO_CHAR(quotes.created_at, 'YYYY-MM-DD')as created_at"),
            'project_actuals.created_at', 
            'products.name as product_name',
            #'product_items.name as product_item_name',
            'conpi.con_piname',
            'customers.customer_name',
            'quantity_actual', 'price',
            #DB::raw("(CAST(quantity as decimal) * CAST(price as decimal)) as totalamount"),
            'actual_final',
            'xs.con_notes',
            #DB::raw("(case when quotes.is_complete = true then 'complete' else 'on-progres' end) as status"),
            'users.name as sales_name'
            )
            #->join('quotes','product_quote.quote_id','=','quotes.id')
            ->join('products','products.id','=','project_actuals.product_id')
            #->join('product_package','product_package.product_id','=','project_actuals.product_id')
            #->join('product_items','product_items.id','=','product_package.product_item_id')
            ->join(DB::raw("(SELECT 
                                pp.product_id, STRING_AGG(pi.name, ', ') AS con_piname
                            FROM product_items pi
                            inner join product_package pp on pp.product_item_id = pi.id
                            GROUP BY pp.product_id
                            )conpi"),
                            function($joinpi)
                            {
                                $joinpi->on('project_actuals.product_id', '=', 'conpi.product_id');
                            })
            ->join('projects','projects.id','=','project_actuals.project_id')
            ->join('customers','customers.id','=','projects.customer_id')
            ->leftJoin('customer_tag','customer_tag.customer_id','=','customers.id')
            ->leftJoin('tags','tags.id','=','customer_tag.tag_id')
            ->join('users','users.id','=','projects.employee_id')
            ->leftJoin(DB::raw("(SELECT 
                        project_id, STRING_AGG(notes, ', ') AS con_notes
                    FROM project_pipeline_stages
                    WHERE pipeline_stage_id = 6
                    GROUP BY project_id
                    )xs"),
                    function($join)
                    {
                        $join->on('projects.id', '=', 'xs.project_id');
                    })
            ->where('projects.pipeline_stage_id', 6)
            ->get();
    }

    public function headings():array
    {
        return ['No','Tanggal','Product','Product Item', 'Company / Clinic','Pax Actual', 'Harga', 'Total Harga', 'Notes', 'Nama Sales'];
    }

    public function map($data): array
    {
        static $number = 1;
        return [
            $number++,
            $data->created_at,
            $data->product_name,
            $data->con_piname,
            $data->customer_name,
            $data->quantity_actual,
            $data->price,
            $data->actual_final,
            $data->con_notes,
            $data->sales_name,
        ];
    }
}
