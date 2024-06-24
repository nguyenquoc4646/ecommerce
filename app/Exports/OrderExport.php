<?php

namespace App\Exports;

use App\Models\OrdersModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OrdersModel::all();
    }
}
