<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\ColorModel;
use App\Models\EvaluateModel;
use App\Models\ProductModel;
use App\Models\SubCategoryModel;


class ProductController extends Controller
{
    public function getProductSearch()
    {

        $meta_title =  'Tìm kiếm';
        $meta_description =  '';
        $meta_keywords =  '';
        $getProByCate = ProductModel::getProduct();
        $getBrand = BrandModel::getRecordActive();
        $getColor = ColorModel::getColor();


        // phần ajax show  thêm dữ liệu khi
        // vào nút xem thêm

        $pageCurrent = 0;
        if (!empty($getProByCate->nextPageUrl())) { // kiểm tra url trang tiếp theo có tồn tại hay không
            $parse_url = parse_url($getProByCate->nextPageUrl()); // phân tích url thành dạng mảng gồm scem, query, host , path...  

            if (!empty($parse_url['query'])) {
                parse_str($parse_url['query'], $get_array); // lấy ra chuổi page có trang phần từ query
                $pageCurrent = !empty($get_array['page']) ? $get_array['page'] : 0;
            }
        }

        $page = $pageCurrent;

        return view('client.product.shop', [
            'getProduct' => $getProByCate,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'page' => $page,
            'getBrand' => $getBrand,
            'getColor' => $getColor
        ]);
    }
    public function getProByCate($slug, $subSlug = '')
    {
        $resultSlugCate = CategoryModel::getCategoryBySlug($slug);
        $resultSlugSubCate = SubCategoryModel::getSubCategoryBySlug($subSlug);

        $data['getBrand'] = BrandModel::getRecordActive();
        $data['getColor'] = ColorModel::getColor();
        $getSingleProduct = ProductModel::getSingleProduct($slug);

        if (!empty($getSingleProduct)) {
            $meta_title = $getSingleProduct->title;
            $meta_description = $getSingleProduct->short_description;
            $getSingleProduct->view = $getSingleProduct->view+1;
            $getSingleProduct->save();
            $getProRelated = ProductModel::getProRelated($getSingleProduct->id, $getSingleProduct->sub_category_id);
            $evaluate = EvaluateModel::getReview($getSingleProduct->id);
            // dd($evaluate);
            $getProduct = $getSingleProduct;
            return view('client.product.detail', [
                'getProduct' => $getProduct,
                'getProRelated' => $getProRelated,
                'evaluate'=>$evaluate

            ]);
        } else 
        
        if (!empty($resultSlugCate) && !empty($resultSlugSubCate)) {
            $category = $resultSlugCate;

            $subCategory = $resultSlugSubCate;
            $meta_title = $subCategory->meta_title;
            $meta_description = $subCategory->meta_description;
            $meta_keywords = $subCategory->meta_keywords;
            $getBrand = $data['getBrand'];
            $getColor = $data['getColor'];
            $getSubCategoryFilter = SubCategoryModel::getSubByCateId($category->id);
            $getProByCate = ProductModel::getProduct($category->id, $subCategory->id);
            // ajax load sản phẩm
            $pageCurrent = 0;
            if (!empty($getProByCate->nextPageUrl())) {
                $parse_url = parse_url($getProByCate->nextPageUrl());
                if (!empty($parse_url['query'])) {
                    parse_str($parse_url['query'], $get_array);
                    $pageCurrent = !empty($get_array['page']) ? $get_array['page'] : 0;
                }
            }

            $page = $pageCurrent;
            return view('client.product.shop', [
                'category' => $category,
                'subCategory' => $subCategory,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'meta_keywords' => $meta_keywords,
                'getBrand' => $getBrand,
                'getColor' => $getColor,
                'getSubCategoryFilter' => $getSubCategoryFilter,
                'getProduct' => $getProByCate,
                'page' => $page
            ]);
        } else if (!empty($resultSlugCate)) {
            $category = $resultSlugCate;
            $getBrand = $data['getBrand'];
            $getColor = $data['getColor'];
            $getSubCategoryFilter = SubCategoryModel::getSubByCateId($category->id);
            $meta_title =  $category->meta_title;
            $meta_description =  $category->meta_description;
            $meta_keywords =  $category->meta_keywords;
            $getProByCate = ProductModel::getProduct($category->id);


            // phần ajax show  thêm dữ liệu khi
            // vào nút xem thêm

            $pageCurrent = 0;
            if (!empty($getProByCate->nextPageUrl())) { // kiểm tra url trang tiếp theo có tồn tại hay không
                $parse_url = parse_url($getProByCate->nextPageUrl()); // phân tích url thành dạng mảng gồm scem, query, host , path...  

                if (!empty($parse_url['query'])) {
                    parse_str($parse_url['query'], $get_array); // lấy ra chuổi page có trang phần từ query
                    $pageCurrent = !empty($get_array['page']) ? $get_array['page'] : 0;
                }
            }

            $page = $pageCurrent;
            return view('client.product.shop', [
                'category' => $category,
                'getBrand' => $getBrand,
                'getColor' => $getColor,
                'getSubCategoryFilter' => $getSubCategoryFilter,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'meta_keywords' => $meta_keywords,
                'getProduct' => $getProByCate,
                'page' => $page
            ]);
        } else {
            abort(404);
        }
    }
    public function getProductFilterAjax(Request $request)
    {


        $getProducts = ProductModel::getProduct();
        $pageCurrent = 0;
        if (!empty($getProducts->nextPageUrl())) { // kiểm tra url trang tiếp theo có tồn tại hay không
            $parse_url = parse_url($getProducts->nextPageUrl()); // phân tích url thành dạng

            if (!empty($parse_url['query'])) {
                parse_str($parse_url['query'], $get_array);
                $pageCurrent = !empty($get_array['page']) ? $get_array['page'] : 0;
            }
        }
        $page = $pageCurrent;
        return response()->json([
            "status" => true,
            'page' => $page,
            "success" => view("client.product._list", [
                "getProduct" => $getProducts,

            ])->render(),

        ], 200);
    }

    // public function detail($slug){
    //     $getSingleProduct = ProductModel::getSingleProduct($slug);
    //     if (!empty($getSingleProduct)) {
    //         $meta_title = $getSingleProduct->title;
    //         $meta_description = $getSingleProduct->short_description;
    //         $getProduct = $getSingleProduct;
    //         return view('client.product.detail', [
    //             'getProduct' => $getProduct,

    //         ]);
    //     }
    // }




}
