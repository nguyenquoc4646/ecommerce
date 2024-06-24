<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    use HasFactory;
    protected $table = 'brand';
    static public function getRecord()
    {
        return self::select('brand.*', 'users.name as create_by_name')
            ->join('users', 'users.id', '=', 'brand.created_by')
            ->where('brand.is_deleted', 0) // Add the where condition
            ->orderBy('brand.id', 'desc')
            ->paginate(10);
    }
    static public function getRecordActive(){
        return self::select('id','name')
        ->where('is_deleted', 0)
        ->where('status','=', 0)
        ->orderBy('name','asc')
        ->get();
        }
}
