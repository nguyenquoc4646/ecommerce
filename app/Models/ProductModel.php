<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';
    static public function checkSlug($slug)
    {
        return self::where('slug', '=', $slug)->count();
    }

    static public function getRecord()
    {
        return self::select('product.*', 'users.name as create_by_name')
            ->join('users', 'users.id', '=', 'product.created_by')
            ->where('product.is_deleted', 0) // Add the where condition
            ->orderBy('product.id', 'desc')
            ->paginate(10);
    }
    static public function getProduct($category_id = '', $sub_category_id = '')
    {

        $return = self::select(
            'product.*',
            'sub_category.name as name_sub_category',
            'sub_category.slug as slug_sub_category',
            'category.slug as slug_category'
        )
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id')
            ->join('category', 'product.category_id', '=', 'category.id');

        if (!empty($category_id)) {
            $return = $return->where('product.category_id', '=', $category_id);
        }

        if (!empty($sub_category_id)) {
            $return = $return->where('product.sub_category_id', '=', $sub_category_id);
        }
        if (!empty(Request::get('sub_category_id'))) {
            $subCategoryId = rtrim(Request::get('sub_category_id'));
            $subCategoryId_array = explode(",", $subCategoryId);
            $return = $return->whereIn('product.sub_category_id', $subCategoryId_array);
        } else {
            if (!empty(Request::get('old_category_id'))) {
                $return = $return->where('product.category_id', '=', Request::get('old_category_id'));
            }

            if (!empty(Request::get('old_sub_category_id'))) {
                $return = $return->where('product.sub_category_id', '=', Request::get('old_sub_category_id'));
            }
        }


        if (!empty(Request::get('brand_id'))) {
            $brand_id = rtrim(Request::get('brand_id'));
            $brand_id_array = explode(",", $brand_id);
            $return = $return->join('brand', 'brand.id', '=', 'product.brand_id');
            $return = $return->whereIn('product.brand_id', $brand_id_array);
        }
        if (!empty(Request::get('get_start_price')) && !empty(Request::get('get_end_price'))) {

            $start_price = str_replace('VNĐ', '', Request::get('get_start_price'));
            $end_price = str_replace('VNĐ', '', Request::get('get_end_price'));
            $return = $return->where('product.price', '>=', $start_price);
            $return = $return->where('product.price', '<=', $end_price);
        }
        if (!empty(Request::get('get_end_price'))) {

            // $start_price = str_replace('vnđ', '', Request::get('get_start_price'));
            $end_price = str_replace('VNĐ', '', Request::get('get_end_price'));
            $return = $return->where('product.price', '>', 0);
            $return = $return->where('product.price', '<=', $end_price);
        }

        if (!empty(Request::get('color_id'))) {
            $color_id = rtrim(Request::get('color_id'));
            $color_id_array = explode(",", $color_id);
            $return = $return->join('product_color', 'product_color.product_id', '=', 'product.id');
            $return = $return->whereIn('product_color.color_id', $color_id_array);
        }
        if (!empty(Request::get('q'))) {
            $return = $return->where('product.title', 'like', '%' . Request::get('q') . '%');
        }



        $return = $return->where('product.is_deleted', '=', 0) // Add the where condition
            ->where('product.status', '=', 0)
            ->groupBy('product.id')
            ->orderBy('product.id', 'desc')
            ->paginate(3);

        return $return;
    }
    static public function getSingleProduct($slug)
    {
        return self::where('slug', '=', $slug)
            ->where('product.is_deleted', '=', 0)
            ->where('product.status', '=', 0)
            ->first();
    }
    static public function getProRelated($product_id, $sub_category_id)
    {
        return self::select(
            'product.*',
            // 'sub_category.id',
            'sub_category.name as name_sub_category',
            'sub_category.slug as slug_sub_category',
            'category.slug as slug_category',
        )
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id')
            ->join('category', 'product.category_id', '=', 'category.id')
            ->where('product.status', '=', 0)
            ->where('product.is_deleted', '=', 0)
            ->where('product.id', '!=', $product_id)
            ->where('product.sub_category_id', '=', $sub_category_id)
            ->limit(10)
            ->get();
    }
    public function checkedColor()
    {
        return $this->hasMany(ProductColorModel::class, 'product_id');
    }
    public function checkedSize()
    {
        return $this->hasMany(ProductSizeModel::class, 'product_id');
    }
    public function getImageByIdPro()
    {
        return $this->hasMany(ProductImageModel::class, 'product_id')->orderBy('order_by', 'asc');
    }
    public function getImageByIdProClient($product_id)
    {
        return ProductImageModel::where('product_id', '=', $product_id)->orderBy('order_by', 'asc')->first();
    }

    public function getCategory()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
    public function getSubCategory()
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_category_id');
    }

    public function checkWishlist($product_id)
    {
        if (!empty(Auth::user()->id)) {
            return WishlistProduct::checkWishlistproductAlready(Auth::user()->id, $product_id);
        }
    }
    static public function getProductWishList($user_id)
    {
        return self::select(
            'product.*',
            'category.slug as slug_category',
            'sub_category.slug as slug_sub_category',
            'sub_category.name as name_sub_category'
        )
            ->join('category', 'category.id', '=', 'product.category_id')
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id')
            ->join('wishlist_product', 'wishlist_product.product_id', '=', 'product.id')
            ->where('wishlist_product.user_id', '=', $user_id)
            ->where('product.status', '=', 0)
            ->where('product.is_deleted', '=', 0)
            ->paginate(10);
    }
    public function totalReview()
    {
        return $this->hasMany(EvaluateModel::class, 'product_id')
            ->join('users', 'users.id', 'evaluate.user_id')
            ->count();
    }

    public function getStarAvg($product_id)
    {
        $avg =  EvaluateModel::getRatingAvg($product_id);
        if ($avg >= 1 && $avg < 1.5) {
            return 20;
        } elseif ($avg >= 1.5 && $avg < 2) {
            return 30;
        } elseif ($avg >= 2 && $avg < 2.5) {
            return 40;
        } elseif ($avg >= 2.5 && $avg < 3) {
            return 50;
        } elseif ($avg >= 3 && $avg < 3.5) {
            return 60;
        } elseif ($avg >= 3.5 && $avg < 4) {
            return 70;
        } elseif ($avg >= 4 && $avg < 4.5) {
            return 80;
        } elseif ($avg >= 4.5 && $avg < 5) {
            return 90;
        } elseif ($avg == 5) {
            return 100;
        } else {
            return 0;
        }
    }

    static public function getAllProduct()
    {
        return  self::select(
            'product.*',
            'sub_category.name as name_sub_category',
            'sub_category.slug as slug_sub_category',
            'category.slug as slug_category'
        )
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id')
            ->join('category', 'product.category_id', '=', 'category.id')

            ->where('product.is_deleted', '=', 0) // Add the where condition
            ->where('product.status', '=', 0)
            ->orderBy('product.id', 'desc')
            ->limit(8)
            ->get();

       
    }
    static public function getProductTrendy()
    {
        return  self::select(
            'product.*',
            'sub_category.name as name_sub_category',
            'sub_category.slug as slug_sub_category',
            'category.slug as slug_category'
        )
            ->join('sub_category', 'sub_category.id', '=', 'product.sub_category_id')
            ->join('category', 'product.category_id', '=', 'category.id')
            ->where('product.is_trendy', '=', 1)
            ->where('product.is_deleted', '=', 0) // Add the where condition
            ->where('product.status', '=', 0)
            ->orderBy('product.id', 'desc')
            ->limit(8)
            ->get();

       
    }


    
   static public function getProductByCategory($category_id)
    {
        return ProductModel::select('product.*', 'category.name as category_name', 'category.slug as category_slug')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->where('product.category_id', '=', $category_id)
            ->limit(8)
            ->get();
    }
}
