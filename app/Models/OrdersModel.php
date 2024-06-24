<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class OrdersModel extends Model
{
    use HasFactory;
    protected $table = 'orders';
    static public function getRecord()
    {
        $return = OrdersModel::select('orders.*');
        if (!empty(Request::get('id'))) {
            $return = $return->where('id', '=', Request::get('id'));
        }
        if (!empty(Request::get('firstName'))) {
            $return = $return->where('firstName', 'like', '%' . Request::get('firstName') . '%');
        }
        if (!empty(Request::get('lastName'))) {
            $return = $return->where('lastName', 'like', '%' . Request::get('lastName') . '%');
        }
        if (!empty(Request::get('address'))) {
            $return = $return->where('address', 'like', '%' . Request::get('address') . '%');
        }
        if (!empty(Request::get('email'))) {
            $return = $return->where('email', 'like', '%' . Request::get('email') . '%');
        }
        if (!empty(Request::get('phone'))) {
            $return = $return->where('id', 'like', '%' . Request::get('phone') . '%');
        }
        if (!empty(Request::get('startDate'))) {
            $return = $return->whereDate('created_at', '>=', Request::get('startDate'));
        }
        if (!empty(Request::get('endDate'))) {
            $return = $return->whereDate('created_at', '<=', Request::get('endDate'));
        }
        $return = $return->where('is_deleted', '=', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return $return;
    }
    static public function latestOrders()
    {
        return OrdersModel::select('orders.*')
            ->where('is_deleted', '=', 0)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
    }
    static public function getSingle($id)
    {
        return self::select('orders.*')
            ->where('orders.id', '=', $id)->first();
    }
    public function getShipping()
    {
        return $this->belongsTo(ShippingModel::class, 'shipping_id');
    }
    public function getOrderItem()
    {
        return $this->hasMany(OrderItemModel::class, 'order_id');
    }


    static public function getTotalOrderUser($user_id)
    {
        return self::select('id')
            ->where('user_id', '=', $user_id)
            ->where('is_deleted', '=', 0)
            ->count();
    }
    static public function getTotalTodayOrderUser($user_id)
    {
        return self::select('id')
            ->where('user_id', '=', $user_id)
            ->where('is_deleted', '=', 0)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->count();
    }

    static public function getTotalAmountOrderUser($user_id)
    {
        return self::select('id')
            ->where('user_id', '=', $user_id)
            ->where('is_payment', '=', 1)
            ->orWhere('status', '=', 3)
            ->where('is_deleted', '=', 0)
            ->sum('total_amount');
    }

    static public function getTotalTodayAmountOrderUser($user_id)
    {
        return self::select('id')
            ->where('user_id', '=', $user_id)
            ->where('is_deleted', '=', 0)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->sum('total_amount');
    }
    static public function getTotalStatusOrder($user_id, $status)
    {
        return self::select('id')
            ->where('status', '=', $status)
            ->where('user_id', '=', $user_id)
            ->where('is_deleted', '=', 0)
            ->count();
    }
    static public function getOrderByUser($user_id)
    {
        return self::select('orders.*')
            ->where('user_id', '=', $user_id)
            ->where('is_deleted', '=', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(30);
    }
    static public function getOrderDetailByUserOrder($user_id, $order_id)
    {
        return self::select('orders.*')
            ->where('user_id', '=', $user_id)
            ->where('id', '=', $order_id)
            ->where('is_deleted', '=', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(30)
            ->first();
    }

    static public function totalOrder()
    {
        return self::select('id')
            ->where('is_deleted', '=', 0)
            ->count();
    }
    static public function totalTodayOrder()
    {
        return self::select('id')
            ->where('is_deleted', '=', 0)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->count();
    }
    static public function totalAmount()
    {
        return self::select('order.*')
            ->where('is_deleted', '=', 0)
            ->where(function ($query) {
                $query->where('status', '=', 3)
                    ->orWhere('is_payment', '=', 1);
            })
            ->sum('total_amount');
    }
    static public function totalTodayAmount()
    {
        return self::select('order.*')
            ->where('is_deleted', '=', 0)
            ->where(function ($query) {
                $query->where('status', '=', 3)
                    ->orWhere('is_payment', '=', 1);
            })
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->sum('total_amount');
    }

    public static function deleteOrder($orderId)
    {
        return self::where('id', $orderId)->delete();
    }

    public function deleteOrderItem()
    {
        // Assuming you have a relationship defined in your Order model
        // that specifies the relationship between orders and order items
        return $this->getOrderItem()->delete();
    }
}
