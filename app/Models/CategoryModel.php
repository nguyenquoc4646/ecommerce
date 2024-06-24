<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'category';
    static public function getRecordActive()
    {
        return self::select('id', 'name', 'slug')
            ->where('is_deleted', 0)
            ->where('status', '=', 0)
            ->orderBy('name', 'asc')
            ->get();
    }
    static public function getRecordActiveHome()
    {
        return self::select('*')
            ->where('is_home', '=', 1)
            ->where('is_deleted', '=', 0)
            ->where('status', '=', 0)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();
    }
    public function getSubCategory()
    {
        return $this->hasMany(SubCategoryModel::class, 'id_category')->where('status', '=', 0)
            ->where('is_deleted', '=', 0);
    }
    static public function getCategoryBySlug($slug)
    {
        return self::select('id', 'name', 'slug', 'meta_title', 'meta_description', 'meta_keywords')
            ->where('slug', '=', $slug)
            ->where('is_deleted', 0)
            ->where('status', '=', 0)
            ->orderBy('name', 'asc')
            ->first();
    }
    public function getImage()
    {
        if (!empty($this->image) && file_exists('upload/category/' . $this->image)) {
            return url('upload/category/' . $this->image);
        } else {
            return '';
        }
    }
}
