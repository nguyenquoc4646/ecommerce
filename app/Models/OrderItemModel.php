<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderItemModel extends Model
{
    use HasFactory;
    protected $table = 'order_item';
    public function getProduct()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
    public function getEvaluate($product_id,$order_id){
        return EvaluateModel::getEvaluate($product_id,$order_id,Auth::user()->id);
    }

    static public function getOrderItem($order_id){
        return self::select('*')
        ->where('order_id','=',$order_id)
        ->get();
    }
 
}
