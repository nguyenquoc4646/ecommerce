<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluateModel extends Model
{
    use HasFactory;
    protected $table = 'evaluate';
    static public function getEvaluate($product_id, $order_id, $user_id)
    {
        return self::select('evaluate.*')
            ->where('order_id', '=', $order_id)
            ->where('product_id', '=', $product_id)
            ->where('user_id', '=', $user_id)
            ->first();
    }

    static public function getReview($product_id)
    {
        return self::select('evaluate.*', 'users.name')
            ->join('users', 'users.id', '=', 'evaluate.user_id')
            ->join('product', 'product.id', '=', 'evaluate.product_id')
            ->where('evaluate.product_id', '=', $product_id)
            ->paginate(10);
    }

    static  public function getRatingAvg($product_id)
    {
        return self::select('*')
            ->join('product', 'product.id', '=', 'evaluate.product_id')
            ->where('evaluate.product_id', '=', $product_id)
            ->avg('evaluate.star');
    }

    public function getPercentStar()
    {
        $rating = $this->star;
        if ($rating == 1) {
            return 20;
        } elseif ($rating == 2) {
            return 40;
        } elseif ($rating == 3) {
            return 60;
        } elseif ($rating == 4) {
            return 80;
        } elseif ($rating == 5) {
            return 100;
        } else {
            return 0;
        }
    }
    static public function totalEvaluate()
    {
        return self::select('id')
            ->count();
    }
    static public function totalTodayEvaluate()
    {
        return self::select('id')
            ->where('created_at', '=', date('Y-m-d'))
            ->count();
    }
}
