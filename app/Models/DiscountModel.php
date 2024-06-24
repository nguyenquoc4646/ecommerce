<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class DiscountModel extends Model
{
    use HasFactory;
    protected $table = 'discount';
    static public function getRecord()
    {
        return self::select('discount.*', 'users.name as create_by_name')
            ->join('users', 'users.id', '=', 'discount.created_by')
            ->where('discount.is_deleted', 0) // Add the where condition
            ->orderBy('discount.id', 'desc')
            ->paginate(10);
    }

    static public function checkDiscount($name)
    {
        return self::select("discount.*")
            ->where('name', '=', $name) // Add the where condition
            ->where('is_deleted', 0) // Add the where condition
            ->where('status', 0) // Add the where condition
            ->where('expire_date', '>=',  Carbon::now())
            ->first();
    }
}
