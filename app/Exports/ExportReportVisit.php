<?php

namespace App\Exports;

use App\Models\Project;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
#use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class ExportReportVisit implements FromCollection, WithHeadings, WithMapping #, WithColumnFormatting
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
        //return Patient::all();
        return Project::select(
                    #DB::raw("TO_CHAR(start_date, 'yyyy-mm-dd')as start_date"),
                    'projects.start_date',
                    'customers.customer_name', 'customers.pic_name', 
                    'xs.con_notes',
                    'users.name',
                    'tags.name as tags_name'
                    )
                    ->join('customers','customers.id','=','projects.customer_id')
                    ->leftJoin('customer_tag','customer_tag.customer_id','=','customers.id')
                    ->leftJoin('tags','tags.id','=','customer_tag.tag_id')
                    ->join('users','users.id','=','projects.employee_id')
                    ->leftJoin(DB::raw("(SELECT 
                                project_id, STRING_AGG(notes, ', ') AS con_notes
                            FROM project_pipeline_stages
                            WHERE pipeline_stage_id = 2
                            GROUP BY project_id
                            )xs"),
                            function($join)
                            {
                                $join->on('projects.id', '=', 'xs.project_id');
                            })
                    ->where('projects.pipeline_stage_id', 2)
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
                            return $query->whereDate('projects.start_date', '>=',  $date_filter_awal);
                    })
                    ->when($this->date_filter_akhir, function ($query, $date_filter_akhir) {
                        if ($date_filter_akhir != '')
                            return $query->whereDate('projects.start_date', '<=',  $date_filter_akhir);
                    })
                    ->get();
    }
    
    public function headings():array
    {
        return ['No','Tanggal','Company/Clinic','PIC Client', 'Result Visit','Nama Sales', 'Tag'];
    }
    
    public function map($visitreport): array
    {
        static $number = 1;
        return [
            $number++,
            #Date::dateTimeToExcel($visitreport->start_date),
            #$visitreport->start_date,
            substr($visitreport->start_date,0,10),
            $visitreport->customer_name,
            $visitreport->pic_name,
            $visitreport->con_notes,
            $visitreport->name,
            $visitreport->tags_name,
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
