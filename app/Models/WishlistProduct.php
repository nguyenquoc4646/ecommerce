<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistProduct extends Model
{
    use HasFactory;
    protected $table = 'wishlist_product';


    static public function checkWishlistproductAlready($user_id, $product_id)
    {
        return self::where('user_id', '=', $user_id)
            ->where('product_id', '=', $product_id)
            ->count();
    }

    static public function DeleteRecord($user_id, $product_id)
    {
       return self::where('user_id', '=', $user_id)
            ->where('product_id', '=', $product_id)
            ->delete();
    }
 
}
