<?php

namespace App\Exports;

use App\Models\ProductQuote;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class ExportReportProposed implements FromCollection, WithHeadings, WithMapping #, WithColumnFormatting
{
    protected $customer_id;
    protected $date_filter_awal;
    protected $date_filter_akhir;
    protected $user_sales_id;

    /* *
    * @return \Illuminate\Support\Collection
    */

    function __construct($customer_id, $user_sales_id, $date_filter)
    {
        $this->customer_id = $customer_id; #!isset($customer_id)? '' : $customer_id;
        $this->date_filter_awal = !isset($date_filter[0])? '' : $date_filter[0];
        $this->date_filter_akhir = !isset($date_filter[1])? '' : $date_filter[1];
        $this->user_sales_id = $user_sales_id; #!isset($user_sales_id)? '' : $user_sales_id;
    }

    public function collection()
    {
        return ProductQuote::select(
            //DB::raw("TO_CHAR(quotes.created_at, 'YYYY-MM-DD')as created_at"),
            'quotes.created_at', 
            'products.name as product_name',
            #'product_items.name as product_item_name',
            'conpi.con_piname',
            'customers.customer_name',
            'quantity', 'price',
            DB::raw("(CAST(quantity as decimal) * CAST(price as decimal)) as totalamount"),
            'xs.con_notes',
            DB::raw("(case when quotes.is_complete = true then 'complete' else 'on-progres' end) as status"),
            'users.name as sales_name'
            )
            ->join('quotes','product_quote.quote_id','=','quotes.id')
            ->join('products','products.id','=','product_quote.product_id')
            #->join('product_package','product_package.product_id','=','product_quote.product_id')
            #->join('product_items','product_items.id','=','product_package.product_item_id')
            ->join(DB::raw("(SELECT 
                                pp.product_id, STRING_AGG(pi.name, ', ') AS con_piname
                            FROM product_items pi
                            inner join product_package pp on pp.product_item_id = pi.id
                            GROUP BY pp.product_id
                            )conpi"),
                            function($joinpi)
                            {
                                $joinpi->on('product_quote.product_id', '=', 'conpi.product_id');
                            })
            ->join('projects','projects.id','=','quotes.project_id')
            ->join('customers','customers.id','=','projects.customer_id')
            ->leftJoin('customer_tag','customer_tag.customer_id','=','customers.id')
            ->leftJoin('tags','tags.id','=','customer_tag.tag_id')
            ->join('users','users.id','=','projects.employee_id')
            ->leftJoin(DB::raw("(SELECT 
                        project_id, STRING_AGG(notes, ', ') AS con_notes
                    FROM project_pipeline_stages
                    WHERE pipeline_stage_id = 3
                    GROUP BY project_id
                    )xs"),
                    function($join)
                    {
                        $join->on('projects.id', '=', 'xs.project_id');
                    })
            ->where('projects.pipeline_stage_id', 3)
            #->where('customers.id', $this->customer_id)
            ->when($this->customer_id, function ($query, $customer_id) {
                if ($customer_id != 'null')
                    return $query->where('customers.id', $customer_id);
            })
            ->when($this->user_sales_id, function ($query, $user_sales_id) {
                if ($user_sales_id != 'null')
                    return $query->where('projects.employee_id', $user_sales_id);
            })
            ->when($this->date_filter_awal, function ($query, $date_filter_awal) {
                if ($date_filter_awal != '')
                    return $query->whereDate('quotes.created_at', '>=',  $date_filter_awal);
            })
            ->when($this->date_filter_akhir, function ($query, $date_filter_akhir) {
                if ($date_filter_akhir != '')
                    return $query->whereDate('quotes.created_at', '<=',  $date_filter_akhir);
            })
            ->get();
    }

    public function headings():array
    {
        return ['No','Tanggal','Product','Product Item', 'Company / Clinic','Pax', 'Harga', 'Total Harga', 'Notes', 'Status', 'Nama Sales'];
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
            $data->quantity,
            $data->price,
            $data->totalamount,
            $data->con_notes,
            $data->status,
            $data->sales_name,
        ];
    }

    /*
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
    */

}
