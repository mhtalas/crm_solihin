<?php

namespace App\Exports;

use App\Models\Task;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class ExportReportTask implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $customer_id;
    protected $date_filter_awal;
    protected $date_filter_akhir;
    protected $user_sales_id;
    /* *
    * @return \Illuminate\Support\Collection
    
    public function collection()
    {
        return Task::all();
    }
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
        return Task::select(
                    DB::raw("TO_CHAR(due_date, 'yyyy-mm-dd')as due_date"),
                    'customers.customer_name', 'customers.pic_name', 
                    DB::raw("regexp_replace(tasks.description, E'<[^>]+>', '', 'gi') as description"),
                    'users.name',
                    DB::raw("(case when is_completed = true then 'complete' else 'on-progres' end) as status"),
                    'tags.name as tags_name'
                    )
                    ->join('projects','projects.id','=','tasks.project_id')
                    ->join('customers','customers.id','=','projects.customer_id')
                    ->leftJoin('customer_tag','customer_tag.customer_id','=','customers.id')
                    ->leftJoin('tags','tags.id','=','customer_tag.tag_id')
                    ->join('users','users.id','=','tasks.user_id')
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
                            return $query->whereDate('due_date', '>=',  $date_filter_awal);
                    })
                    ->when($this->date_filter_akhir, function ($query, $date_filter_akhir) {
                        if ($date_filter_akhir != '')
                            return $query->whereDate('due_date', '<=',  $date_filter_akhir);
                    })
                    ->get();
    }

    public function headings():array
    {
        return ['Due Date','Company/Clinic','PIC Client', 'Deskripsi','Nama Sales', 'Status', 'Tag'];
    }

    public function map($taskreport): array
    {
        return [
            Date::dateTimeToExcel($taskreport->due_date),
            $taskreport->customer_name,
            $taskreport->pic_name,
            $taskreport->description,
            $taskreport->name,
            $taskreport->status,
            $taskreport->tags_name,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

}
