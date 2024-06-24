<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingModel extends Model
{
    use HasFactory;
    protected $table = 'shipping';
    static public function getRecord()
    {
        return self::select('shipping.*', 'users.name as create_by_name')
            ->join('users', 'users.id', '=', 'shipping.created_by')
        
            ->where('shipping.is_deleted', 0) // Add the where condition
            ->orderBy('shipping.id', 'desc')
            ->paginate(10);
    }

    // static public function getColor()
    // {
    //     return self::select('id','name','code')
    //         ->where('is_deleted', 0) // Add the where condition
    //         ->where('status', 0) // Add the where condition
    //         ->orderBy('name', 'asc')
    //         ->get();
    // }
}
