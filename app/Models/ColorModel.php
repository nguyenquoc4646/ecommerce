<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorModel extends Model
{
    use HasFactory;
    protected $table = 'color';
    static public function getRecord()
    {
        return self::select('color.*', 'users.name as create_by_name')
            ->join('users', 'users.id', '=', 'color.created_by')
            ->where('color.is_deleted', 0) // Add the where condition
            ->orderBy('color.id', 'desc')
            ->paginate(10);
    }

    static public function getColor()
    {
        return self::select('id','name','code')
            ->where('is_deleted', 0) // Add the where condition
            ->where('status', 0) // Add the where condition
            ->orderBy('name', 'asc')
            ->get();
    }
}
