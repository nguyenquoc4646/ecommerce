<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
  use HasFactory;
  protected $table = 'sub_category';
  static public function getRecord()
  {
    return self::select('sub_category.*', 'users.name as create_by_name', 'category.name as category_name')
      ->join('category', 'category.id', '=', 'sub_category.id_category')
      ->join('users', 'users.id', '=', 'sub_category.created_by')
      ->where('sub_category.is_deleted', 0) // Add the where condition
      ->orderBy('sub_category.id', 'desc')
      ->paginate(10);
  }
  static public function getSubByCateId($id)
  {
    return self::select('id', 'name')
      ->where('id_category', '=', $id)
      ->where('is_deleted', 0)
      ->where('status', '=', 0)
      ->orderBy('name', 'asc')
      ->get();
  }
  static public function getSubCategoryBySlug($slug)
  {
    return self::select('id', 'name', 'slug', 'meta_title', 'meta_description', 'meta_keywords')
      ->where('slug', '=', $slug)
      ->where('is_deleted', 0)
      ->where('status', '=', 0)
      ->first();
  }
  public function totalProduct()
  {
    return $this->hasMany(ProductModel::class, 'sub_category_id')
      ->where('product.status', '=', 0)
      ->where('product.is_deleted', '=', 0)
      ->count();
  }
}
