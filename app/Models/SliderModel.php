<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderModel extends Model
{
    use HasFactory;
    protected $table = 'slider';
    static public function getRecord()
    {
        return self::select('slider.*')
            ->where('slider.is_deleted', 0)
            ->orderBy('slider.id', 'desc')
            ->paginate(10);
    }
    static public function getRecordActive()
    {
        return self::select('slider.*')
            ->where('slider.status', 0)
            ->where('slider.is_deleted', 0)
            ->orderBy('slider.id', 'desc')
            ->paginate(10);
    }
    public function getImage()
    {
        if (!empty($this->image) && file_exists('upload/slider/' . $this->image)) {
            return url('upload/slider/' . $this->image);
        } else {
            return '';
        }
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
