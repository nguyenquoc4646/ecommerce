<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Statistical extends Model
{
    use HasFactory;
    protected $table = 'statistical';

    static public function dataFilter($startDate, $endDate)
    {
        return self::select('statistical.*')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->orderBy('order_date', 'asc')->get();
    }

    // static public function dataFilterByOption($optionValue)
    // {
    //     $endDate = Carbon::now();
    //     $startDate = $endDate->subDays(30);
    //     $return =  self::select('statistical.*');
    //     if (!empty(Request::get('optionValue') == 'sevenDays')) {
    //         $return = $return->whereBetween('order_date', Carbon::now());
    //     }
    //     return $return;
    // }
}
